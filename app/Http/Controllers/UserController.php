<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ExerciceRepository;
use App\Repositories\TypesExerciceRepository;
use App\Repositories\ObjectifRepository;
use App\Repositories\PratiqueRepository;
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
    protected $pratiqueRepository;

    public function __construct(UserRepository $userRepository, ExerciceRepository $exerciceRepository, TypesExerciceRepository $typesExerciceRepository,
        ObjectifRepository $objectifRepository, PratiqueRepository $pratiqueRepository)
    {
        $this->userRepository = $userRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
        $this->typesExerciceRepository = $typesExerciceRepository;
        $this->objectifRepository = $objectifRepository;
        $this->pratiqueRepository = $pratiqueRepository;
    }

    public function getServices(){
        return view('services');
    }

    public function getSeancesByUser(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            $pratiques = $this->pratiqueRepository->getPratiquesByIdUser(Auth::user()->id);
            $reponse = ['seances' => $pratiques,  'succes' => 'OK'];
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
    }

    public function getExercicesByUser(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            $exercices = $this->exerciceRepository->getExercicesByIdUser(Auth::user()->id);
            foreach($exercices as $exercice){
                
                //setter le type d'exercice
                $typeExercice = (object) array('id' => $exercice->typeId, 'nom' => $exercice->typeNom, 'urlNom' => $exercice->typeUrlNom);
                $exercice->typeExercice = $typeExercice;
                $this->getTypeExerciceUpdated($exercice->typeExercice);

                //setter url
                if($exercice->url != '' && str_contains($exercice->url, 'youtu')){
                    $exercice->idVideo =  substr($exercice->url, 17, 30);
                }
            }
                
            $reponse = ['exercices' => $exercices, 'succes' => 'OK'];
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
