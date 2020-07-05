<?php

namespace App\Repositories;

use App\Equipe;

use DB;

class EquipeRepository{

	protected $equipe;
	protected $joueurRepository;
	protected $saisonRepository;

	public function __construct(Equipe $equipe){
		$this->equipe = $equipe;
    }

    public function save(Equipe $equipe, Array $inputs){
		$equipe->nom = isset($inputs['nom']) ? $inputs['nom'] : '';
		$equipe->logo = isset($inputs['logo']) ? $inputs['logo'] : '';
		if(isset($inputs['club_id'])){
			$equipe->club_id =$inputs['club_id'];
		}
		$equipe->users_id = $inputs['users_id'];
        $equipe->save();
    }
    
    public function store(Array $inputs){
		$equipe = new Equipe;
		//create équipe
		$this->save($equipe, $inputs);

		//create saison
		if(isset($inputs['saison']) && isset($inputs['saison']['nom'])){
			if($this->createSaisonByEquipe($equipe->id, $inputs['saison'])){
				$equipe->saison = $inputs['saison'];
			}
		}
		
		//create joueurs
		$lstJoueurs = collect();
		foreach ($inputs['joueurs'] as $joueur) {
			if($this->createJoueursByEquipe($equipe->id, $joueur)){
				$lstJoueurs->push($joueur);
			}
		}

		$equipe->lstJoueurs = $lstJoueurs;

		//create entraineurs
		$lstEntraineurs = collect();
		foreach ($inputs['entraineurs'] as $entraineur) {
			if($this->createEntraineurByEquipe($equipe->id, $entraineur)){
				$lstEntraineurs->push($entraineur);
			}
		}

		$equipe->lstEntraineurs = $lstEntraineurs;
		
		return $equipe;
	}
	
	public function createSaisonByEquipe($idEquipe, $saison){
		return DB::table('saison_equipes')->insert(
			['nom' => $saison['nom'], 'date_debut' => $saison['dateDebut'],
			'date_fin' => $saison['dateFin'], 'equipe_id' => $idEquipe]
		);
	}

	public function createJoueursByEquipe($idEquipe, $joueur){
		$email = isset($joueur['email']) ? $joueur['email'] : '';
		$prenom = isset($joueur['prenom']) ? $joueur['prenom'] : '';
		$position1 = isset($joueur['position1']) ? $joueur['position1'] : '';
		$position2 = isset($joueur['position2']) ? $joueur['position2'] : '';
		$position3 = isset($joueur['position3']) ? $joueur['position3'] : '';

		return DB::table('joueurs')->insert(
			['nom' => $joueur['nom'], 'prenom' => $prenom,
			'email' => $email, 'equipe_id' => $idEquipe, 'position1' => $position1,
			'position2' => $position2, 'position3' => $position3]
		);
	}

	public function createJoueurAndGetId($idEquipe, $joueur){
		$email = isset($joueur['email']) ? $joueur['email'] : '';
		$prenom = isset($joueur['prenom']) ? $joueur['prenom'] : '';
		$position1 = isset($joueur['position1']) ? $joueur['position1'] : '';
		$position2 = isset($joueur['position2']) ? $joueur['position2'] : '';
		$position3 = isset($joueur['position3']) ? $joueur['position3'] : '';

		return DB::table('joueurs')->insertGetId(
			['nom' => $joueur['nom'], 'prenom' => $prenom,
			'email' => $email, 'equipe_id' => $idEquipe, 'position1' => $position1,
			'position2' => $position2, 'position3' => $position3]
		);
	}

	public function createEntraineurByEquipe($idEquipe, $entraineur){
		$role = isset($entraineur['role']) ? $entraineur['role'] : '';
		$prenom = isset($entraineur['prenom']) ? $entraineur['prenom'] : '';

		return DB::table('entraineurs')->insert(
			['nom' => $entraineur['nom'], 'prenom' => $prenom,
			'role' => $role, 'equipe_id' => $idEquipe]
		);
	}

	public function createEntraineurAndGetId($idEquipe, $entraineur){
		$role = isset($entraineur['role']) ? $entraineur['role'] : '';
		$prenom = isset($entraineur['prenom']) ? $entraineur['prenom'] : '';

		return DB::table('entraineurs')->insertGetId(
			['nom' => $entraineur['nom'], 'prenom' => $prenom,
			'role' => $role, 'equipe_id' => $idEquipe]
		);
	}

	public function createActiviteAndGetId($idEquipe, $activite, $terrain, $type){
		$arrival = isset($entraineur['arrival']) ? $entraineur['arrival'] : '';
		$time = isset($entraineur['time']) ? $entraineur['time'] : '';
		$adversaire = isset($entraineur['adversaire']) ? $entraineur['adversaire'] : '';

		//create terrain
		$idTerrain = $this->createTerrain($terrain);

		return DB::table('activites')->insertGetId(
			['nom' => $activite['nom'], 'type' => $type,
			'date_debut' => $activite['dateDebut'], 'arrival' => $arrival,
			'time' => $time, 'adversaire' => $adversaire, 'equipe_id' => $idEquipe,
			'terrain_id' => $idTerrain, 'saison_id' => $activite['saison']]
		);
	}

	public function createTerrain($terrain){
		return DB::table('terrains')->insertGetId(
			['nom' => $terrain['nom'], 'code_postal' => $terrain['codePostal'],
			'adresse_ligne1' => $terrain['adresseLigne1'], 'adresse_ligne2' => $terrain['adresseLigne2'],
			'url_terrain' => $terrain['urlTerrain']]
		);
	}

    public function getEquipesByIdUser($idUser){
		return DB::table('equipes')
		->select('equipes.*')
		->where('equipes.users_id', '=', $idUser)
		->orderBy('equipes.created_at', 'desc')
		->get();
	}

	public function getJoueursByEquipe($idEquipe){
		return DB::table('joueurs')
		->select('joueurs.*')
		->where('joueurs.equipe_id', '=', $idEquipe)
		->orderBy('joueurs.nom', 'asc')
		->get();
	}

	public function getEntraineursByEquipe($idEquipe){
		return DB::table('entraineurs')
		->select('entraineurs.*')
		->where('entraineurs.equipe_id', '=', $idEquipe)
		->orderBy('entraineurs.nom', 'asc')
		->get();
	}

	public function getSaisonByEquipe($idEquipe){
		return DB::table('saison_equipes')
		->select('saison_equipes.*')
		->where('saison_equipes.equipe_id', '=', $idEquipe)
		->orderBy('saison_equipes.created_at', 'desc')
		->first();
	}

	public function getPratiquesByEquipe($idEquipe){
		return DB::table('activites')
		->select(DB::raw('activites.*, terrains.nom AS nomTerrain, terrains.id AS idTerrain, pratique.theme AS theme'))
		->leftJoin('terrains', 'activites.terrain_id', '=',  'terrains.id')
		->leftJoin('pratique', 'activites.seance_id', '=',  'pratique.id')
		->where('activites.equipe_id', '=', $idEquipe)
		->where('activites.type', '=', 'pratique')
		->orderBy('activites.date_debut', 'asc')
		->get();
	}

	public function getMatchsByEquipe($idEquipe){
		return DB::table('activites')
		->select(DB::raw('activites.*, terrains.nom AS nomTerrain, terrains.id AS idTerrain'))
		->leftJoin('terrains', 'activites.terrain_id', '=',  'terrains.id')
		->leftJoin('pratique', 'activites.seance_id', '=',  'pratique.id')
		->where('activites.equipe_id', '=', $idEquipe)
		->where('activites.type', '=', 'match')
		->orderBy('activites.date_debut', 'asc')
		->get();
	}

	public function deleteJoueurById($id){
		DB::table('joueurs')->where('id', '=', $id)->delete();
	}

	public function deleteEntraineurById($id){
		DB::table('entraineurs')->where('id', '=', $id)->delete();
	}

	public function deleteJoueursByIdEquipe($idEquipe){
		DB::table('joueurs')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deleteSaisonByIdEquipe($idEquipe){
		DB::table('saison_equipes')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deleteEntraineursByIdEquipe($idEquipe){
		//supprimer usagers liés aux entraineurs
		DB::table('entraineurs')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deleteEquipe($id){
		//supprimer saison
		$this->deleteSaisonByIdEquipe($id);

		//supprimer joueurs
		$this->deleteJoueursByIdEquipe($id);

		//supprimer entraineurs
		$this->deleteEntraineursByIdEquipe($id);

		//TODO supprimer matchs

		//TODO supprimer pratiques

		//supprimer équipe
		DB::table('equipes')->where('id', '=', $id)->delete();
	}
}