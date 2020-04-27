<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExerciceRequest;
use App\Http\Requests\UpdateExerciceRequest;
use App\Repositories\ExerciceRepository;
use App\Repositories\TypesExerciceRepository;
use App\Gestion\PhotoGestion;

use PDF;
use Str;
use Auth;

class ExerciceController extends Controller
{
    protected $exerciceRepository;
    protected $typesExerciceRepository;
    protected $nbPerPege = 6;
    protected $icons_type_exercice;
    protected $types;

    public function __construct(ExerciceRepository $exerciceRepository, TypesExerciceRepository $typesExerciceRepository)
    {
        $this->exerciceRepository = $exerciceRepository;
        $this->typesExerciceRepository = $typesExerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
        $this->types = $this->typesExerciceRepository->getAll();
    }
    
    public function index()
    {
        $exercices = $this->exerciceRepository->getPaginate($this->nbPerPege);
        $links = $exercices->render();
        $types = $this->types;

        foreach($exercices as $exercice){
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }

        $this->updateTypeExerciceList($types, null);
        
        return view('exercices', compact('exercices', 'links', 'types'));
    }

    public function type($idType){
        $exercices = $this->exerciceRepository->getExercicesByType($idType, $this->nbPerPege);
        $links = $exercices->render();
        $types = $this->types;

        foreach($exercices as $exercice){
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }

        $this->updateTypeExerciceList($types, $idType);

        return view('exercices-type', compact('exercices', 'links', 'types'));
    }

    public function create()
    {
        $types = $this->types;
        return view('add-exercice', compact('types'));
    }

    public function store(ExerciceRequest $request, PhotoGestion $photogestion){}

    public function show($id)
    {
        $exercice = $this->exerciceRepository->getById($id);
        $this->getTypeExerciceUpdated($exercice->typeExercice);

        if($exercice->url != '' && str_contains($exercice->url, 'youtu')){
            $exercice->idVideo =  substr($exercice->url, 17, 30);
        }
        
        return view('detail-exercice',  compact('exercice'));
    }

    public function edit($id)
    {
        $exercice = $this->exerciceRepository->getById($id);
        $types = $this->types;
        
        return view('update-exercice',  compact('exercice', 'types'));
    }
  
    public function update(UpdateExerciceRequest $request, $id){}

    public function updateExercice(Request $request, PhotoGestion $photogestion){
        $image =  '';
        if($request->file('image') != null){
            $image = $photogestion->save($request->file('image'));
        }
        $exercice = $this->exerciceRepository->getById($request->id);
        $requestArray = $request->all();
        $requestArray['image'] = $image;
        $requestArray['users_id'] = Auth::user()->id;
        $this->exerciceRepository->update($exercice, $requestArray);

        $reponse = ['image' => $image, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function createExercice(Request $request, PhotoGestion $photogestion){
        $image =  '';
        if($request->file('image') != null){
            $image = $photogestion->save($request->file('image'));
        }
        $requestArray = $request->all();
        $requestArray['image'] = $image;
        $requestArray['users_id'] = Auth::user()->id;
        $exercice = $this->exerciceRepository->store($requestArray);

        $reponse = ['exercice' => $exercice, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function destroy($id)
    {
        $this->exerciceRepository->destroy($id);
        return redirect('exercice');
    }

    /** CUSTOM FUNCTIONS */
    public function printPDF($id)
    {
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

}
