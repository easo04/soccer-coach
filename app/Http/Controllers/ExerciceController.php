<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExerciceRequest;
use App\Http\Requests\UpdateExerciceRequest;
use App\Repositories\ExerciceRepository;
use App\Repositories\TypesExerciceRepository;
use App\Repositories\ObjectifRepository;
use App\Repositories\FavorisRepository;
use App\Gestion\PhotoGestion;

use PDF;
use Str;
use Auth;

class ExerciceController extends Controller
{
    protected $exerciceRepository;
    protected $typesExerciceRepository;
    protected $nbPerPege = 9;
    protected $icons_type_exercice;
    protected $objectifRepository;
    protected $objectifs;
    protected $typeSelected;
    protected $favorisRepository;

    public function __construct(ExerciceRepository $exerciceRepository, TypesExerciceRepository $typesExerciceRepository, ObjectifRepository $objectifRepository, FavorisRepository $favorisRepository)
    {
        //$this->middleware('auth', ['except' => ['index', 'indexTag']]);
        //$this->middleware('admin', ['only' => 'destroy']);
        
        $this->favorisRepository = $favorisRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->typesExerciceRepository = $typesExerciceRepository;
        $this->objectifRepository = $objectifRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
    }
    
    public function index(){
        $exercices = $this->exerciceRepository->getPaginate($this->nbPerPege);
        $links = $exercices->render();
        $types = $this->typesExerciceRepository->getAll();

        foreach($exercices as $exercice){   
            $exercice->principeUrl = Str::slug($exercice->principe, '-');
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }

        $this->updateTypeExerciceList($types, null);

        $objectifs = $this->objectifRepository->getAll();
        
        return view('exercices', compact('exercices', 'links', 'types', 'objectifs'));
    }

    public function type($idType, $urlNom){
        $exercices = $this->exerciceRepository->getExercicesByType($idType, $this->nbPerPege);
        $links = $exercices->render();
        $types = $this->typesExerciceRepository->getAll();
        $objectifs = $this->objectifRepository->getAll();

        foreach($exercices as $exercice){
            $exercice->principeUrl = Str::slug($exercice->principe, '-');
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }

        $this->updateTypeExerciceList($types, $idType);

        $typeSelected = $this->typeSelected;

        return view('exercices-type', compact('exercices', 'links', 'types', 'objectifs', 'typeSelected'));
    }

    public function create(){
        return view('add-exercice');
    }

    public function store(ExerciceRequest $request, PhotoGestion $photogestion){}

    public function show($id, $nom){
        $idUser = Auth::user()->id;
        $exercice = $this->exerciceRepository->getById($id);
        if($exercice->private == 1 && (auth()->guest() || $idUser != $exercice->users_id)){
            return redirect('/');
        }

        $types = $this->typesExerciceRepository->getAll();
        $objectifs = $this->objectifRepository->getAll();

        $this->getTypeExerciceUpdated($exercice->typeExercice);

        if($exercice->url != '' && str_contains($exercice->url, 'youtu')){
            $exercice->idVideo =  substr($exercice->url, 17, 30);
        }

        //vérifier si l'exercice est favoris
        $exercice->isFavoris = $this->favorisRepository->isExerciceFavorisForAuthUser($idUser, $id) ? 1 : 0;
        
        return view('detail-exercice',  compact('exercice', 'types', 'objectifs'));
    }

    public function edit($id){
        $exercice = $this->exerciceRepository->getById($id);
        return view('update-exercice',  compact('exercice'));
    }
    
    public function update(UpdateExerciceRequest $request, $id){}

    public function updateExercice(Request $request, PhotoGestion $photogestion){
        $image =  '';
        if($request->file('image') != null){
            $image = $photogestion->save($request->file('image'));
        }else if(isset($request->image)){
            $image = $request->image;
        }

        $exercice = $this->exerciceRepository->getById($request->id);
        $requestArray = $request->all();
        $requestArray['image'] = $image;
        $requestArray['users_id'] = Auth::user()->id;
        $exercice = $this->exerciceRepository->update($exercice, $requestArray);
        //setter le type de l'exercice
        $exercice->typeExercice = $this->exerciceRepository->getTypeExerciceByExe($exercice->id);

        $reponse = ['message' => 'Exercice modifié', 'exercice' => $exercice, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function createExercice(Request $request, PhotoGestion $photogestion){
        $image =  '';
        if($request->file('image') != null){
            $image = $photogestion->save($request->file('image'));
        }else if(isset($request->image)){
            $image = $request->image;
        }

        $requestArray = $request->all();
        $requestArray['image'] = $image;
        $requestArray['users_id'] = Auth::user()->id;
        $exercice = $this->exerciceRepository->store($requestArray);
        //setter le type de l'exercice
        $exercice->typeExercice = $this->exerciceRepository->getTypeExerciceByExe($exercice->id);

        $reponse = ['exerciceId' => $exercice->id, 'exercice' => $exercice, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function getImagesExerciceUser(){
        $images = $this->exerciceRepository->getImagesByExercicesUser(Auth::user()->id);
        $reponse = ['images' => $images, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function getVariantesAndObjectifsByExe($id){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            //get variantes
            $lstVariantes = $this->exerciceRepository->getVariantesById($id);
            //get objectifs
            $lstObjectifs = $this->exerciceRepository->getObjectifsById($id);

            $reponse = ['variantes' => $lstVariantes, 'objectifs' => $lstObjectifs];
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
    }

    public function destroy($id){
        $this->exerciceRepository->destroy($id);
        return response()->json('exercice supprimé', 200);
    }

    public function getByObjectif($objectif){
        $exercices = $this->exerciceRepository->getExercicesWithObjectifPaginate($objectif, $this->nbPerPege);
        $links = $exercices->render();

        foreach($exercices as $exercice){
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }

        $types = $this->typesExerciceRepository->getAll();
        $objectifs = $this->objectifRepository->getAll();

        $objectifSearch = $objectif;
        $nomObjectifSearch = $this->getObjectifNameFormatted($objectif);
        
        return view('exercices', compact('exercices', 'links', 'objectifSearch', 'nomObjectifSearch', 'objectifs', 'types'));
    }
    

    /** CUSTOM FUNCTIONS */
    public function printPDF($id){
        $exercice = $this->exerciceRepository->getById($id);
        $data = [
        'principe' => $exercice->principe,
        'sousPrincipe' => $exercice->sousPrincipe,
        'image' => $exercice->image,
        'time' => $exercice->time,
        'sousPrincipe' => $exercice->sousPrincipe,
        'nbJoueurs' => $exercice->nbJoueurs,
        'physique' => $exercice->physique,
        'nbJoueurs' => $exercice->nbJoueurs,
        'observations' => $exercice->observations,
        'typeExercice' => $exercice->typeExercice,
        'description' => $exercice->description];
        $pdfModel = new PDF;
        $pdf =  PDF::loadView('pdf_view_exercice', $data);  
        return $pdf->download('exercice_' . camel_case($exercice->principe)  . '.pdf');
    }

    /** Function pour l'API */
    public function getExerices(){
        $exercices = $this->exerciceRepository->getPaginate($this->nbPerPege);
        $types = $this->typesExerciceRepository->getAll();
        $reponse = array('exercices' => $exercices, 'types' => $types);

        return response()->json($reponse, 200);
    }

    /**
     * Permet de retourner la liste de types d'exercices modifiée
     */
    private function getTypeExerciceUpdated($type){
        $type->icon = $this->icons_type_exercice[$type->urlNom];
    }


    private function updateTypeExerciceList($types, $idType){
        foreach($types as $type){
            $type->icon = $this->icons_type_exercice[$type->urlNom];
            $type->nom = $this->getTypeNameFormated($type->nom);
            if($type->id == $idType){
                $type->selected = true;
                $this->typeSelected = $type;
            }
        }
    }

    private function getTypeNameFormated($name){
        $retval = '';
        $collect = Str::of($name)->explode(' ');
        foreach ($collect as $str) {
            $str = Str::plural($str);
            $retval = $retval . $str . ' ' ;
        }
        return $retval;
    }

    private function getObjectifNameFormatted($nomUrl){
        $retval = '';
        $collect = Str::of($nomUrl)->explode('_');
        foreach ($collect as $str) {
            $retval = $retval . $str . ' ' ;
        }
        return Str::ucfirst($retval);
    }

}
