<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ExerciceRepository;
use App\Repositories\TypesExerciceRepository;
use App\Repositories\ObjectifRepository;
use App\Repositories\PratiqueRepository;
use App\Repositories\EquipeRepository;
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
    protected $equipesRepository;

    private $ERROR_CODE_AUCUN_CLUB = 100;

    public function __construct(UserRepository $userRepository, ExerciceRepository $exerciceRepository, TypesExerciceRepository $typesExerciceRepository,
        ObjectifRepository $objectifRepository, PratiqueRepository $pratiqueRepository, EquipeRepository $equipeRepository)
    {
        $this->userRepository = $userRepository;
        $this->exerciceRepository = $exerciceRepository;
        $this->icons_type_exercice = array('principe-offensif' => 'ti-target', 'principe-defensif' => 'ti-hummer', 'rondos' => 'ti-cup', 'physique' => 'ti-heart');
        $this->typesExerciceRepository = $typesExerciceRepository;
        $this->objectifRepository = $objectifRepository;
        $this->pratiqueRepository = $pratiqueRepository;
        $this->equipeRepository = $equipeRepository;
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

    public function getEquipesToAuthUser(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            $equipes = $this->equipeRepository->getEquipesByIdUser(Auth::user()->id);
            $reponse = ['equipes' => $equipes, 'succes' => 'OK'];
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
    }

    public function getActivitesByEntraineur(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            //TODO vérifier si entraineur ou joueur
            $activites = $this->equipeRepository->getMesActivitesEntraineurs(Auth::user()->id);
            $reponse = ['activites' => $activites, 'succes' => 'OK'];
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
    }

    public function getInfosClub(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){

            //obtenir le club de l'usager connecté
            $club = $this->userRepository->getInfosClub(Auth::user()->id);
            if($club){
                $equipes = $this->equipeRepository->getEquipesByClub($club->id);
                $reponse = ['club' => $club, 'equipes' => $equipes, 'succes' => 'OK'];
                $reponseNo = 200;
            }else{
                $reponse = ['message' => 'aucun club', 'errorCode' => $ERROR_CODE_AUCUN_CLUB];
            }
            
        }
        return response()->json($reponse, $reponseNo);
    }

    public function getEntraineursByClub(){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){

            //obtenir le club de l'usager connecté
            $club = $this->userRepository->getInfosClub(Auth::user()->id);
            if($club){
                $entraineurs = $this->equipeRepository->getEntraineursByClub($club->id);
                $reponse = ['entraineurs' => $entraineurs, 'succes' => 'OK'];
                $reponseNo = 200;
            }else{
                $reponse = ['message' => 'aucun club', 'errorCode' => $ERROR_CODE_AUCUN_CLUB];
            }
            
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
