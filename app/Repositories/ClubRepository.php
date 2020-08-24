<?php

namespace App\Repositories;

use App\Club;

use DB;
use DateInterval;
use DateTime;
use Auth;

class ClubRepository{

    protected $club;

	public function __construct(Club $club){
		$this->club = $club;
    }

    public function save(Club $club, Array $inputs){
		/*$equipe->nom = isset($inputs['nom']) ? $inputs['nom'] : '';
		$equipe->logo = isset($inputs['logo']) ? $inputs['logo'] : ''; 
		if(isset($inputs['clubId'])){
			$equipe->club_id =$inputs['clubId'];
		}
		$equipe->users_id = $inputs['users_id'];
        $equipe->save();*/
    }
    
    public function store(Array $inputs){
		/*$equipe = new Equipe;
		//create équipe
		$this->save($equipe, $inputs);
		
		return $equipe;*/
	}

	public function update(Array $inputs){

		//modifier club
		$affectedEquipe = DB::table('clubs')
            ->where('id', $inputs['id'])
            ->update(['nom' => $inputs['nom'], 'no_telephone' => $inputs['telephone'], 'adresse_ligne1' => $inputs['adresseLigne1'], 'adresse_ligne2' => $inputs['adresseLigne2'], 
            'code_postal' => $inputs['codePostal'], 'ville' => $inputs['ville'], 'province' => $inputs['province']]);
		
		return $affectedEquipe;
	}
}