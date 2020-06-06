<?php

namespace App\Http\Controllers;
use App\Gestion\PhotoGestion;
use Illuminate\Http\Request;
use App\Repositories\PratiqueRepository;
use App\Repositories\ExerciceRepository;

use Auth;

class PratiquesController extends Controller
{

    protected $pratiqueRepository;
    protected $exerciceRepository;

    public function __construct(PratiqueRepository $pratiqueRepository, ExerciceRepository $exerciceRepository)
    {
        $this->pratiqueRepository = $pratiqueRepository;
        $this->exerciceRepository = $exerciceRepository;
    }

    public function create(){
        return view('create-pratique');
    }

    public function show($id){
        $pratique = $this->pratiqueRepository->getById($id);
        if(Auth::user()->id != $pratique->users_id){
            return redirect('/');
        }
        
        return view('details-pratique', compact('pratique'));
    }

    public function getExercicesBySeanceId($id){
        //récupérer la liste d'exercices d'une séance
        $lstExercices = $this->pratiqueRepository->getExercicesByPratiqueId($id);
        //récupérer les variantes de chaque exercice
        foreach($lstExercices as $exercice){
            $exercice->variantes = $this->exerciceRepository->getVariantesById($exercice->id);
        }

        return response()->json(['exercices' => $lstExercices,  'succes' => 'OK'], 200);
    }

    public function updateSeance(Request $request, PhotoGestion $photogestion){
        $image =  '';
        $lstImagesById = collect();

        //récupérer les nouvelles images et les enregistrer
        if(isset($request->lstExercices)){
            $lstExercices = $request->lstExercices;				
            foreach ($lstExercices as $exe) {
                $exeJson = json_decode($exe, true);
                $image =  '';
                if(isset($exeJson['newAdded']) && $request->file('image_' . $exeJson['index']) != null){
                    $image = $photogestion->save($request->file('image_' . $exeJson['index']));                  
                    //ajouter l'image dans la liste d'images
                    $lstImagesById->put('image_' . $exeJson['index'], $image);                                  
                }           
            }
        }

        $pratique = $this->pratiqueRepository->getById($request->id);
        $requestArray = $request->all();
        $requestArray['users_id'] = Auth::user()->id;
        $requestArray['lstImagesById'] = $lstImagesById;
        $requestArray['image'] = $image;
        $seance = $this->pratiqueRepository->update($pratique, $requestArray);

        $reponse = ['seance' => $seance, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function createSeance(Request $request, PhotoGestion $photogestion){
        $image =  '';
        $lstImagesById = collect();

        //récupérer les nouvelles images et les enregistrer
        if(isset($request->lstExercices)){
            $lstExercices = $request->lstExercices;				
            foreach ($lstExercices as $exe) {
                $exeJson = json_decode($exe, true);
                $image =  '';
                if(isset($exeJson['newAdded']) && $request->file('image_' . $exeJson['index']) != null){
                    $image = $photogestion->save($request->file('image_' . $exeJson['index']));                  
                    //ajouter l'image dans la liste d'images
                    $lstImagesById->put('image_' . $exeJson['index'], $image);                                  
                }           
            }
        }

        $requestArray = $request->all();
        $requestArray['users_id'] = Auth::user()->id;
        $requestArray['lstImagesById'] = $lstImagesById;
        $requestArray['image'] = $image;
        $seance = $this->pratiqueRepository->store($requestArray);

        $reponse = ['seance' => $seance, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function destroy($id){
        $this->pratiqueRepository->destroy($id);
        return response()->json('séance supprimé', 200);
    }


    //ROUTES TESTS
    public function getIdExercices($id){
        $retour = collect();
        $response = $this->pratiqueRepository->getTest($id);
        foreach ($response as $value) {
            $retour->push($value->id);
        }
        $reponse = ['response' => $retour, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }
}
