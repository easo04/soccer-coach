<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FavorisRepository;
use App\Repositories\ExerciceRepository;

use Auth;

class FavorisController extends Controller
{
    protected $favorisRepository;
    protected $exerciceRepository;

    public function __construct(FavorisRepository $favorisRepository, ExerciceRepository $exerciceRepository){
        $this->middleware('auth');
        $this->favorisRepository = $favorisRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
    }

    public function addExerciceToFavoris(Request $request){
        $message = '';
        $reponseNo = 500;
        $userId = Auth::user()->id;
        //vérifier si l'exercice est public
        if($this->canAddToFavoris($request->exericeId, $userId)){
            $requestArray = $request->all();
            $requestArray['users_id'] = Auth::user()->id;
            $requestArray['exercice_id'] = $request->exericeId;
            $this->favorisRepository->store($requestArray);
            $message = 'OK';
            $reponseNo = 200;
        }else{
            $message = 'Exercice ne peut pas être ajouté';
        }    
        $reponse = array('message' => $message);
        return response()->json($reponse, $reponseNo);
    }

    //Permet de déterminer si un exercice peut être ajouté dans les favoris de l'usager
    private function canAddToFavoris($idExercice, $userId){
        $isPublic = $this->exerciceRepository->isExercicePublic($idExercice);
        $isFavorisAdded = $this->favorisRepository->isExerciceFavorisForAuthUser($userId, $idExercice);

        return $isPublic && !$isFavorisAdded;
    }

    public function getFavorisToAuthUser(){
        $favoris = $this->favorisRepository->getFavorisToAuthUser(Auth::user()->id);
        foreach($favoris as $exercice){
            //setter le type d'exercice
            $typeExercice = (object) array('id' => $exercice->typeId, 'nom' => $exercice->typeNom, 'urlNom' => $exercice->typeUrlNom);
            $exercice->typeExercice = $typeExercice;
            $this->getTypeExerciceUpdated($exercice->typeExercice);

            //setter url
            if($exercice->url != '' && str_contains($exercice->url, 'youtu')){
                $exercice->idVideo =  substr($exercice->url, 17, 30);
            }
        }
        $reponse = array('favoris' => $favoris);
        return response()->json($reponse, 200);
    }

    
    /**
     * Permet de retourner la liste de types d'exercices modifiée
     */
    private function getTypeExerciceUpdated($type){
        $type->icon = $this->icons_type_exercice[$type->urlNom];
    }

    public function deleteFavoris($id){
        $this->favorisRepository->deleteByIdExe($id);
        $response = 'SUPPRIMÉ';
        return response()->json($response, 200);
    }
}
