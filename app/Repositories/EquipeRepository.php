<?php

namespace App\Repositories;

use App\Equipe;

use DB;
use DateInterval;
use DateTime;

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

	public function update(Array $inputs){

		//modifier ou ajouter saison
		$this->updateOrCreateSaison($inputs['id'], $inputs['saison']);

		//modifier équipe
		$affectedEquipe = DB::table('equipes')
            ->where('id', $inputs['id'])
			->update(['nom' => $inputs['nom']]);
		
		return $affectedEquipe;
	}

	private function updateOrCreateSaison($idEquipe, $saison){
		if(isset($saison['id'])){
			DB::table('saison_equipes')
            ->where('id', $saison['id'])
			->update(['nom' => $saison['nom'],
					'date_debut' => $saison['dateDebut'],
					'date_fin' => $saison['dateFin']]);
		}else if(isset($saison['nom'])){
			$this->createSaisonByEquipe($idEquipe, $saison);
		}
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

	public function updateJoueur($joueur){
		$email = isset($joueur['email']) ? $joueur['email'] : '';
		$nom = isset($joueur['nom']) ? $joueur['nom'] : '';
		$prenom = isset($joueur['prenom']) ? $joueur['prenom'] : '';
		$position1 = isset($joueur['position1']) ? $joueur['position1'] : '';
		$position2 = isset($joueur['position2']) ? $joueur['position2'] : '';
		$position3 = isset($joueur['position3']) ? $joueur['position3'] : '';

		$affected = DB::table('joueurs')
            ->where('id', $joueur['id'])
			->update(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 
			'position1' => $position1, 'position2' => $position2, 'position3' => $position3]);
		
		return $affected;
	}

	public function updateEntraineur($entraineur){
		$nom = isset($entraineur['nom']) ? $entraineur['nom'] : '';
		$role = isset($entraineur['role']) ? $entraineur['role'] : '';

		$affected = DB::table('entraineurs')
            ->where('id', $entraineur['id'])
			->update(['nom' => $nom, 'role' => $role]);
		
		return $affected;
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

	public function createActiviteAndGetId($idEquipe, $activite){
		$arrival = isset($activite['arrival']) ? $activite['arrival'] : '';
		$time = isset($activite['time']) ? $activite['time'] : '';
		$adversaire = isset($activite['adversaire']) ? $activite['adversaire'] : null;
		$saison = isset($activite['saisonId']) ? $activite['saisonId'] : null;
		$type = $activite['type'];
		$lstIdActivites = collect();

		//create terrain
		$idTerrain = $this->createTerrain($activite['terrain']);

		//vérifier s'il y a un période
		if($type == 'pratique' && $activite['periode'] != 'une'){
			$dateDebut = new DateTime($activite['dateDebut']);
			$dateFin = new DateTime($activite['dateFin']);
			$periode = $this->getPeriodeToAdd($activite['periode']);
			$datePratique = $dateDebut;

			do {
				$idAdded = DB::table('activites')->insertGetId(
					['nom' => $activite['nom'], 'type' => $type,
					'date_debut' => $datePratique, 'heure_debut' => $activite['heureDebut'], 'arrival' => $arrival,
					'time' => $time, 'adversaire' => $adversaire, 'equipe_id' => $idEquipe,
					'terrain_id' => $idTerrain, 'saison_id' => $saison]
				);

				//ajouter l'id à la liste
				$lstIdActivites->push($idAdded);

				//ajouter la période à la date de la pratique
				$datePratique = $datePratique->add(new DateInterval($periode));
			} while($datePratique <= $dateFin);
		}else{
			$idAdded = DB::table('activites')->insertGetId(
				['nom' => $activite['nom'], 'type' => $type,
				'date_debut' => $activite['dateDebut'], 'heure_debut' => $activite['heureDebut'], 'arrival' => $arrival,
				'time' => $time, 'adversaire' => $adversaire, 'equipe_id' => $idEquipe,
				'terrain_id' => $idTerrain, 'saison_id' => $saison]
			);
			$lstIdActivites->push($idAdded);
		}
		return $lstIdActivites;
	}

	public function updateActivite($idEquipe, $activite){
		$arrival = isset($activite['arrival']) ? $activite['arrival'] : '';
		$time = isset($activite['time']) ? $activite['time'] : '';
		$adversaire = isset($activite['adversaire']) ? $activite['adversaire'] : null;
		$saison = isset($activite['saisonId']) ? $activite['saisonId'] : null;

		//get id terrain
		$idTerrain = $this->createTerrain($activite['terrain']);

		//make update
		$affected = DB::table('activites')->where('id', $activite['id'])
			->update(['nom' => $activite['nom'],
				'date_debut' => $activite['dateDebut'], 'heure_debut' => $activite['heureDebut'], 
				'arrival' => $arrival, 'time' => $time, 
				'adversaire' => $adversaire, 'equipe_id' => $idEquipe,
				'terrain_id' => $idTerrain, 'saison_id' => $saison]
		);
		
		return $idTerrain;
	}

	private function getPeriodeToAdd($periode){
		$retval = '';
		switch ($periode) {
			case 'deux':
				$retval = 'P14D';
			break;
			case 'hebdo':
				$retval = 'P7D';
			break;
			case 'mensuel':
				$retval = 'P1M';
			break;
		}

		return $retval;
	}

	public function createTerrain($terrain){
		$idTerrain = isset($terrain['id']) ? $terrain['id'] : null;

		if($idTerrain == null){
			$adresseLigne1 = isset($terrain['adresseLigne1']) ? $terrain['adresseLigne1'] : '';
			$adresseLigne2 = isset($terrain['adresseLigne2']) ? $terrain['adresseLigne2'] : '';
			$codePostal = isset($terrain['codePostal']) ? $terrain['codePostal'] : '';
			$urlTerrain = isset($terrain['urlTerrain']) ? $terrain['urlTerrain'] : '';
	
			return DB::table('terrains')->insertGetId(
				['nom' => $terrain['nom'], 'code_postal' => $codePostal,
				'adresse_ligne1' => $adresseLigne1, 'adresse_ligne2' => $adresseLigne2,
				'url_terrain' => $urlTerrain]
			);
		}

		return $idTerrain;
	}

    public function getEquipesByIdUser($idUser){
		return DB::table('equipes')
		->select(DB::raw('equipes.*, saison_equipes.nom AS nomSaison, saison_equipes.date_debut as dateDebutSaison,
						date_fin as dateFinSaison'))
		->leftJoin('saison_equipes', 'saison_equipes.equipe_id', '=',  'equipes.id')
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
		->select(DB::raw('activites.*, terrains.nom AS nomTerrain, terrains.id AS idTerrain, 
						pratique.theme AS theme, terrains.url_terrain AS urlTerrain, 
						terrains.adresse_ligne1 AS adresseLigne1, terrains.adresse_ligne2 AS adresseLigne2,
						terrains.code_postal AS codePostalTerrain'))
		->leftJoin('terrains', 'activites.terrain_id', '=',  'terrains.id')
		->leftJoin('pratique', 'activites.seance_id', '=',  'pratique.id')
		->where('activites.equipe_id', '=', $idEquipe)
		->where('activites.type', '=', 'pratique')
		->orderBy('activites.date_debut', 'asc')
		->get();
	}

	public function getMatchsByEquipe($idEquipe){
		return DB::table('activites')
		->select(DB::raw('activites.*, terrains.nom AS nomTerrain, terrains.id AS idTerrain,
						terrains.url_terrain AS urlTerrain, 
						terrains.adresse_ligne1 AS adresseLigne1, terrains.adresse_ligne2 AS adresseLigne2,
						terrains.code_postal AS codePostalTerrain'))
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

	public function deleteActiviteById($id){
		DB::table('activites')->where('id', '=', $id)->delete();
	}

	public function deleteJoueursByIdEquipe($idEquipe){
		DB::table('joueurs')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deleteSaisonByIdEquipe($idEquipe){
		DB::table('saison_equipes')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deleteEntraineursByIdEquipe($idEquipe){
		//TODO supprimer usagers liés aux entraineurs
		DB::table('entraineurs')->where('equipe_id', '=', $idEquipe)->delete();
	}

	public function deletePratiquesByIdEquipe($idEquipe){
		//TODO supprimer pratiques liés aux activités de type entraînements
		//TODO supprimer présences liées aux activités
		DB::table('activites')
		->where('equipe_id', '=', $idEquipe)
		->where('type', '=', 'pratique')
		->delete();
	}

	public function deleteMatchsByIdEquipe($idEquipe){
		//TODO supprimer présences liées aux activités
		//todo supprimer notes
		DB::table('activites')
		->where('equipe_id', '=', $idEquipe)
		->where('type', '=', 'match')
		->delete();
	}

	public function getAllTerrainsByUser($idUser){
		return DB::table('terrains')
		->select('terrains.*')
		->rightJoin('activites', 'activites.terrain_id', '=',  'terrains.id')
		->leftJoin('equipes', 'equipes.id', '=',  'activites.equipe_id')
		->where('equipes.users_id', '=', $idUser)
		->orderBy('terrains.nom', 'asc')
		->groupBy('terrains.id')
		->get();
	}

	public function getAllEquipesByUser($idUser){
		return DB::table('activites')
		->select('activites.adversaire')
		->leftJoin('equipes', 'equipes.id', '=',  'activites.equipe_id')
		->where('equipes.users_id', '=', $idUser)
		->where('activites.type', '=', 'match')
		->orderBy('activites.adversaire', 'asc')
		->distinct()
		->get();
	}

	public function deleteEquipe($id){
		//supprimer saison
		$this->deleteSaisonByIdEquipe($id);

		//supprimer joueurs
		$this->deleteJoueursByIdEquipe($id);

		//supprimer entraineurs
		$this->deleteEntraineursByIdEquipe($id);

		//supprimer matchs
		$this->deletePratiquesByIdEquipe($id);

		//supprimer pratiques
		$this->deleteMatchsByIdEquipe($id);

		//supprimer équipe
		DB::table('equipes')->where('id', '=', $id)->delete();
	}

	public function getAssistancesByActivite($idActivite){
		return DB::table('presences')
		->select(DB::raw('presences.*, users.name as nameUser'))
		->join('users', 'users.id', '=', 'presences.user_updated_id')
		->where('presences.activite_id', $idActivite)
		->get();
	}

	public function savePresences($inputs){
		foreach ($inputs['presences'] as $presence) {
			$typePresence = $presence['isPresent'] == 'true' ? 'present' : 'absent';
			DB::table('presences')->insert(
				['presence' => $typePresence, 'joueur_id' => $presence['idJoueur'],
				'date_last_update' => new DateTime($presence['date']), 'activite_id' => $inputs['idActivite'], 
				'user_updated_id' => $inputs['user']]
			);
		}
	}


}

