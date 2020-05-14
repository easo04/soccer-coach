<?php

namespace App\Repositories;

use App\Exercice;
use App\Repositories\DB;
use App\TypesExercice;
use App\Repositories\VarianteRepository;

class ExerciceRepository
{

	protected $exercice;
	protected $varianteRepository;

	public function __construct(Exercice $exercice, VarianteRepository $varianteRepository)
	{
		$this->exercice = $exercice;
		$this->varianteRepository = $varianteRepository;
	}

	public function save(Exercice $exercice, Array $inputs)
	{

		if($inputs['image'] != ''){
			$exercice->image =$inputs['image'];
		}
		$exercice->principe =$inputs['principe'];
		$exercice->sousPrincipe = $inputs['sousPrincipe'];
		$exercice->physique = $inputs['physique'];
		$exercice->time = $inputs['time'];
		$exercice->nbJoueurs = $inputs['nbJoueurs'];
		$exercice->description = $inputs['description'];
		$exercice->observations = $inputs['observations']; 
		$exercice->url = $inputs['url']; 
		$exercice->typesexcercice_id = $inputs['typesexcercice_id'];
		$exercice->users_id =$inputs['users_id'];

		if($inputs['private'] == 'true'){
			$exercice->private = 1;
		}else{
			$exercice->private = 0;
		}
		

        $exercice->save();
	}

	public function getPaginate($n){
		return $this->exercice->with('typeExercice')->where('exercice.private', '0')
		->orderBy('exercice.created_at', 'desc')
		->paginate($n);
	}

	public function getExercicesByType($idType, $n){
		return $this->exercice->with('typeExercice')->where('exercice.typesexcercice_id', $idType)
		->orderBy('exercice.created_at', 'desc')
		->paginate($n);
	}

	public function getExercicesByUser($idUser, $n){
		return $this->exercice->with('typeExercice')->where('exercice.users_id', $idUser)
		->orderBy('exercice.created_at', 'desc')
		->paginate($n);
	}

	public function getExercicesByIdUser($idUser){
		return $this->exercice->with('typeExercice', 'objectifs')->where('exercice.users_id', $idUser)
		->orderBy('exercice.created_at', 'desc')->get();
	}

	public function getVariantesById($id){
		$variantes = $this->exercice->find($id)->variantes;
		return $variantes;
	}

	public function store(Array $inputs){
		$exercice = new Exercice;
		$this->save($exercice, $inputs);

		//créer variantes 
		if(isset($inputs['lstVariables'])){
			$lstVariantes = $inputs['lstVariables'];
			$lstVariantesAdded =  collect();
			foreach($lstVariantes as $variante){
				$variante = json_decode($variante, true);
				$array = array('description' => $variante['description'], 'time' => $variante['time'], 'exercice_id' => $exercice->id);
				$lstVariantesAdded->push($this->varianteRepository->store($array));
			}
			$exercice->lstVariantes = $lstVariantesAdded;
		}	

		//créer les objectifs
		if(isset($inputs['lstObjectifs'])){
			$lstObjectifs = $inputs['lstObjectifs'];
			foreach ($lstObjectifs as $key => $objectif) {
				$exercice->objectifs()->attach($objectif);		
			}

			$exercice->objectifs()->detach($objectif->id);
		}

		return $exercice;
	}

	public function getById($id){
		return $this->exercice->findOrFail($id);
	}

	public function update($exercice,  Array $inputs){

		//update les variantes 
		if(isset($inputs['lstVariables'])){
			$lstVariantes = $inputs['lstVariables'];

			$lstVariantesExercice = $exercice->variantes;
			//supprimer les variantes
			foreach ($lstVariantesExercice as $v) {
				$varianteFind = false;
				foreach ($lstVariantes as $item) {
					$itemJson = json_decode($item, true);
					if(isset($itemJson['id']) && $itemJson['id'] == $v->id){
						$varianteFind = true;
						break;
					}
				}
				if(!$varianteFind){
					$this->varianteRepository->destroy($v->id);
				}				
			}

			//ajouter les nouvelles variantes
			foreach($lstVariantes as $variante){
				$variante = json_decode($variante, true);
				if(!isset($variante['id'])){
					$array = array('description' => $variante['description'], 'time' => $variante['time'], 'exercice_id' => $exercice->id);
					$this->varianteRepository->store($array);
				}			
			}	
		}	

		//update les objectifs
		if(isset($inputs['lstObjectifs'])){
			$lstObjectifs = $inputs['lstObjectifs'];

			$lstIdObjectifsByExercice = collect();

			//detacher les objectifs liés
			$lstObjectifsByExercice = $exercice->objectifs;
			foreach ($lstObjectifsByExercice as $objectif) {
				$lstIdObjectifsByExercice->push($objectif->id);
				$objectifFind = false;
				foreach ($lstObjectifs as $o) {
					if($o == $objectif->id){
						$objectifFind = true;
						break;
					}		
				}

				if(!$objectifFind){
					$exercice->objectifs()->detach($objectif->id);
				}

			}

			foreach ($lstObjectifs as $key => $objectif) {
				if(!$lstIdObjectifsByExercice->contains($objectif)){
					$exercice->objectifs()->attach($objectif);	
				}				
			}
		}else{
			$exercice->objectifs()->detach();
		}

		$this->save($exercice, $inputs);
	}

	public function destroy($id){
		$exercice = $this->getById($id);

		foreach($exercice->variantes as $variante){
			$this->varianteRepository->destroy($variante->id);
		}

		$exercice->objectifs()->detach();
		$exercice->delete();
	}

	public function getExercicesWithObjectifPaginate($objectif, $n){
		return $this->exercice->with('typeExercice', 'objectifs')->where('exercice.private', '0')
		->orderBy('exercice.created_at', 'desc')
		->whereHas('objectifs', function($q) use ($objectif)
		{
			$q->where('objectifs.nom_url', $objectif);
		})->paginate($n);	
	}

	public function getImagesByExercicesUser($idUser){
		return $this->exercice->select('image')->distinct()->where('exercice.users_id', $idUser)->get();
	}

}