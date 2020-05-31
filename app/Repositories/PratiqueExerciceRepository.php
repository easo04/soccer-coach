<?php

namespace App\Repositories;

use App\PratiqueExercice;
use DB;

class PratiqueExerciceRepository{

    protected $pratiqueExercice;

	public function __construct(PratiqueExercice $pratiqueExercice)
	{
		$this->pratiqueExercice = $pratiqueExercice;
    }
    
    public function save(PratiqueExercice $pratiqueExercice, Array $inputs){

		$pratiqueExercice->description = $inputs['description'];
        $pratiqueExercice->observations = $inputs['observations'];
        $pratiqueExercice->nbJoueurs = $inputs['nbJoueurs'];
        $pratiqueExercice->time =$inputs['time'];
        $pratiqueExercice->exercice_id  =$inputs['exercice_id'];
        $pratiqueExercice->pratique_id  =$inputs['pratique_id'];

        $pratiqueExercice->save();
    }

	public function store(Array $inputs){
		$pratiqueExercice = new PratiqueExercice;
		$this->save($pratiqueExercice, $inputs);
		return $pratiqueExercice;
    }
    
    public function deleteByIdPratique($id){
        DB::table('pratique_exercice')->where('pratique_id', '=', $id)->delete();
    }

    public function deleteByIdExercice($id){
        DB::table('pratique_exercice')->where('exercice_id', '=', $id)->delete();
    }

}