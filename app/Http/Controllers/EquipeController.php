<?php

namespace App\Http\Controllers;

use App\Repositories\EquipeRepository;
use App\Repositories\PratiqueRepository;
use Illuminate\Http\Request;

use Auth;
use DateTime;
use DateInterval;

class EquipeController extends Controller{

    protected $equipeRepository;
    protected $pratiqueRepository;

    public function __construct(EquipeRepository $equipeRepository, PratiqueRepository $pratiqueRepository){
        $this->equipeRepository = $equipeRepository;
        $this->pratiqueRepository = $pratiqueRepository;
    }

    public function createEquipe(Request $request){
        $requestArray = $request->all();
        $requestArray['users_id'] = Auth::user()->id;
        $equipe = $this->equipeRepository->store($requestArray);

        $reponse = ['equipe' => $equipe, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function updatequipe(Request $request){
        $requestArray = $request->all();
        $requestArray['users_id'] = Auth::user()->id;
        $equipe = $this->equipeRepository->update($requestArray);

        $reponse = ['equipe' => $equipe, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function deleteEquipe($id){
        $this->equipeRepository->deleteEquipe($id);
        $reponse = ['message' => 'équipe supprimé', 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function getJoueursAndSaisonByEquipe($id){
        $joueurs = $this->equipeRepository->getJoueursByEquipe($id);
        $saison = $this->equipeRepository->getSaisonByEquipe($id);
        $entraineurs = $this->equipeRepository->getEntraineursByEquipe($id);
        $pratiques = $this->equipeRepository->getPratiquesByEquipe($id);

        //attacher les séances pour chaque pratique
        foreach ($pratiques as $pratique){
            if(isset($pratique->seance_id)){
                $pratique->seance = $this->pratiqueRepository->getSeanceById($pratique->seance_id);
            }
        }
        
        $matchs = $this->equipeRepository->getMatchsByEquipe($id);

        $reponse = ['joueurs' => $joueurs, 'saison' => $saison,
            'entraineurs' => $entraineurs, 'pratiques' => $pratiques, 'matchs' => $matchs, 
            'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function getTerrainsAndEquipes(){
        $terrains = $this->equipeRepository->getAllTerrainsByUser(Auth::user()->id);
        $adversaires = $this->equipeRepository->getAllEquipesByUser(Auth::user()->id);
        $equipes = collect();
        foreach ($adversaires as $adversaire) {
            $equipes->push($adversaire->adversaire);
        }
        $reponse = ['terrains' => $terrains, 'equipes' => $equipes];
        return response()->json($reponse, 200);
    }

    public function createJoueur(Request $request){
        $joueur = $request->all();
        $idEquipe = $joueur['equipe'];
        $joueur = $this->equipeRepository->createJoueurAndGetId($idEquipe, $joueur);
        $reponse = ['joueur' => $joueur, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function updateJoueur(Request $request){
        $joueur = $this->equipeRepository->updateJoueur($request->all());
        $reponse = ['joueur' => $joueur, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function updateEntraineur(Request $request){
        $entraineur = $this->equipeRepository->updateEntraineur($request->all());
        $reponse = ['entraineur' => $entraineur, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function deleteJoueur(Request $request){
        $joueur = $request->all();
        $idJoueur = $joueur['idJoueur'];
        $this->equipeRepository->deleteJoueurById($idJoueur);
        $reponse = ['message' => 'joueur supprimé', 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function createEntraineur(Request $request){
        $entraineur = $request->all();
        $idEquipe = $entraineur['equipe'];
        $entraineur = $this->equipeRepository->createEntraineurAndGetId($idEquipe, $entraineur);
        $reponse = ['entraineur' => $entraineur, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function deleteEntraineur(Request $request){
        $entraineur = $request->all();
        $idEntraineur = $entraineur['idEntraineur'];
        $this->equipeRepository->deleteEntraineurById($idEntraineur);
        $reponse = ['message' => 'entraineur supprimé', 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function createActivite(Request $request){
        $activite = $request->all();
        $idEquipe = $activite['equipe'];
        $lstIdActivites = $this->equipeRepository->createActiviteAndGetId($idEquipe, $activite);
        $reponse = ['activites' => $lstIdActivites, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function deleteActivite(Request $request){
        $activite = $request->all();
        $idActivite = $activite['idActivite'];
        $this->equipeRepository->deleteActiviteById($idActivite);
        $reponse = ['message' => 'actovoté supprimé', 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function updateActivite(Request $request){
        $activite = $request->all();
        $idEquipe = $activite['equipe'];
        $idTerrain = $this->equipeRepository->updateActivite($idEquipe, $activite);
        $reponse = ['idTerrain' => $idTerrain, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function getAssistancesByActivite($idActivite){
        $lstAssistance = $this->equipeRepository->getAssistancesByActivite($idActivite);
        $reponse = ['lstAssistance' => $lstAssistance, 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }

    public function savePresences(Request $request){
        $inputs = $request->all();
        $inputs['user'] = Auth::user()->id;
        $this->equipeRepository->savePresences($inputs);
        $reponse = ['message' => 'Sauvegardés', 'succes' => 'OK'];
        return response()->json($reponse, 200);
    }
}
