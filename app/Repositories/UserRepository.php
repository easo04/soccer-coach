<?php

namespace App\Repositories;

use App\User;

use DB;

class UserRepository{

    protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
    }

    public function getById($id){
		return $this->user->findOrFail($id);
	}
	
	public function getExercicesPaginate($id, $n){
		return DB::table('users')
		->where('users.id', $id)
		->join('typesexcercice', 'exercice.users_id', '=', 'users.id')
		->orderBy('exercice.created_at', 'desc')
		->get();
	}

    public function update($variante,  Array $inputs){
		$this->save($variante, $inputs);
	}

}