<?php

namespace App\Repositories;

use App\Variante;
use App\Repositories\DB;

class VarianteRepository{

    protected $variante;

	public function __construct(Variante $variante)
	{
		$this->variante = $variante;
    }
    
    public function save(Variante $exercice, Array $inputs){
		if($inputs['image'] != ''){
			$variante->image =$inputs['image'];
		}

		$variante->description = $inputs['description'];
        $variante->users_id =$inputs['exercice_id'];
        $variante->time =$inputs['time'];

        $variante->save();
    }
    
    public function getVariantesByExercice($idExercice){
		return $this->variante->with('exercice')->where('variante.exercice_id', $idExercice)
		->orderBy('variante.created_at', 'desc');
	}

	public function store(Array $inputs){
		$variante = new Variante;
		$this->save($variante, $inputs);

		return $variante;
	}

	public function getById($id){
		return $this->variante->findOrFail($id);
    }
    
    public function update($variante,  Array $inputs){
		$this->save($variante, $inputs);
	}

	public function destroy($id){
		$this->getById($id)->delete();
	}

}