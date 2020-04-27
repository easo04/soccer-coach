<?php

namespace App\Repositories;

use App\TypesExercice;

class TypesExerciceRepository
{

    protected $typeExercice;

	public function __construct(TypesExercice $typeExercice)
	{
		$this->typeExercice = $typeExercice;
	}

	public function save(TypesExercice $typeExercice, Array $inputs)
	{
        $typeExercice->nom = $inputs['nom'];
        $typeExercice->save();
	}

	public function getPaginate($n){
		return $this->typeExercice->paginate($n);
	}

	public function getAll(){
		return $this->typeExercice->all();
	}

	public function getExercicesById($id, $n){
		$exercices = $this->typeExercice->find($id)->exercices;
		return $exercices;
	}

	public function store(Array $inputs){
		$typeExercice = new TypesExercice;
		$this->save($typeExercice, $inputs);

		return $typeExercice;
	}

	public function getById($id){
		return $this->typeExercice->findOrFail($id);
	}

	public function update($id,  Array $inputs){
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id){
		$this->getById($id)->delete();
	}

}