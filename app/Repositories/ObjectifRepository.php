<?php
namespace App\Repositories;

use App\Objectifs;
use Illuminate\Support\Str;

class ObjectifRepository
{

    protected $objectif;

    public function __construct(Objectifs $objectif)
	{
		$this->objectif = $objectif;
    }
    
    public function getAll(){
		return $this->objectif->all();
	}

	public function store($exercice, $objectifs)
	{
		//$tags = explode(',', $tags);

		foreach ($objectifs as $objectif) {

			//$tag = trim($tag);

			//$tag_url = Str::slug($objectif);

			$objectif_ref = $this->objectif->where('nom_url', $objectif)->first();

			if(!is_null($tag_ref)){
                $exercice->objectifs()->attach($objectif_ref->id);					
			}

		}

	}

}