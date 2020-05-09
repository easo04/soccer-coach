<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ExerciceRepository;
use App\Repositories\TypesExerciceRepository;
use App\Repositories\ObjectifRepository;
use Illuminate\Http\Request;

use Str;
use Auth;

class UserController extends Controller
{

    protected $icons_type_exercice;
    protected $userRepository;
    protected $exerciceRepository;
    protected $typesExerciceRepository;
    protected $nbPerPege = 6;
    protected $objectifRepository;

    public function __construct(UserRepository $userRepository, ExerciceRepository $exerciceRepository, TypesExerciceRepository $typesExerciceRepository,
        ObjectifRepository $objectifRepository)
    {
        $this->userRepository = $userRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
        $this->typesExerciceRepository = $typesExerciceRepository;
        $this->types = $this->typesExerciceRepository->getAll();
        $this->objectifRepository = $objectifRepository;
    }

    public function getExercices(){
        if(auth()->check()){
            $exercices = $this->exerciceRepository->getExercicesByIdUser(Auth::user()->id);   
            $types = $this->types;

            foreach($exercices as $exercice){
                $this->getTypeExerciceUpdated($exercice->typeExercice);
            }

            $this->updateTypeExerciceList($types, null);

            $objectifs = $this->objectifRepository->getAll();

            return view('exercices-by-user',  compact('exercices', 'types', 'objectifs')); 
        }
    }

    public function getExercicesByUser(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            $exercices = $this->exerciceRepository->getExercicesByIdUser(Auth::user()->id);
            $reponse = array('exercices' => $exercices);
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
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

    /**
     * Permet de retourner la liste de types d'exercices modifiée
     */
    private function getTypeExerciceUpdated($type){
        $type->icon = $this->icons_type_exercice[$type->urlNom];
    }
}
