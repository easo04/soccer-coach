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
    }

    public function addExerciceToFavoris(Request $request){
        $message = '';
        $reponseNo = 500;
        //vérifier si l'exercice est public
        if($this->exerciceRepository->isExercicePublic($request->exericeId)){
            $requestArray = $request->all();
            $requestArray['users_id'] = Auth::user()->id;
            $requestArray['exercice_id'] = $request->exericeId;
            $this->favorisRepository->store($requestArray);
            $message = 'OK';
            $reponseNo = 200;
        }else{
            $message = 'Exercice non plublic';
        }    
        $reponse = array('message' => $message);
        return response()->json($reponse, $reponseNo);
    }

    public function getFavorisToAuthUser(){
        $favoris = $this->favorisRepository->getFavorisToAuthUser(Auth::user()->id);
        $reponse = array('favoris' => $favoris);
        return response()->json($reponse, 200);
    }
}
