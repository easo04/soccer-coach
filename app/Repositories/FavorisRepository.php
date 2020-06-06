<?php

namespace App\Repositories;

use App\Favoris;

use DB;

class FavorisRepository
{

	protected $favoris;

	public function __construct(Favoris $favoris){
        $this->favoris = $favoris;
    }

    public function save(Favoris $favoris, Array $inputs){
        $favoris->exercice_id  =$inputs['exercice_id'];
        $favoris->users_id  =$inputs['users_id'];
        $favoris->save();
    }

    public function store(Array $inputs){
        $favoris = new Favoris;
        $this->save($favoris, $inputs);
        return $favoris;
    }

    public function getFavorisToAuthUser($idUser){
        return DB::table('exercice')
        ->select('exercice.*', 'typesexcercice.nom AS typeExerciceNom')
        ->leftJoin('typesexcercice', 'typesexcercice.id', '=', 'exercice.typesexcercice_id')
        ->join('favoris', 'favoris.exercice_id', '=', 'exercice.id')
        ->where('favoris.users_id', '=', $idUser)
        ->get();
    }

    public function deleteByIdUser($id){
        DB::table('favoris')->where('users_id', '=', $id)->delete();
    }

    public function deleteByIdExerciceAndUser($idUser, $idExercice){
        DB::table('favoris')
        ->where('exercice_id', '=', $idExercice)
        ->where('users_id', '=', $idUser)
        ->delete();
    }
}