<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ExerciceRepository;
use Illuminate\Http\Request;

use Str;
use Auth;

class UserController extends Controller
{

    protected $icons_type_exercice;
    protected $userRepository;
    protected $exerciceRepository;
    protected $nbPerPege = 6;

    public function __construct(UserRepository $userRepository, ExerciceRepository $exerciceRepository)
    {
        $this->userRepository = $userRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
    }

    public function getExercices(){
        $exercices = $this->exerciceRepository->getExercicesByUser(Auth::user()->id, $this->nbPerPege);
        $links = $exercices->render();
        foreach($exercices as $exercice){
            $this->getTypeExerciceUpdated($exercice->typeExercice);
        }
        
        return view('exercices-by-user',  compact('exercices', 'links')); 
    }

    /**
     * Permet de retourner la liste de types d'exercices modifiée
     */
    private function getTypeExerciceUpdated($type){
        $type->icon = $this->icons_type_exercice[$type->urlNom];
    }
}
