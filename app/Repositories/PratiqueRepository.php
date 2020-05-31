<?php

namespace App\Repositories;

use App\Pratique;
use App\Repositories\ExerciceRepository;
use App\Repositories\PratiqueExerciceRepository;

use DB;

class PratiqueRepository
{

	protected $pratique;
	protected $exerciceRepository;
	protected $pratiqueExerciceRepository;

	public function __construct(Pratique $pratique, ExerciceRepository $exerciceRepository, PratiqueExerciceRepository $pratiqueExerciceRepository)
	{
		$this->pratique = $pratique;
		$this->exerciceRepository = $exerciceRepository;
		$this->pratiqueExerciceRepository = $pratiqueExerciceRepository;
	}

	public function save(Pratique $pratique, Array $inputs)
	{
		$pratique->time = $inputs['time']; 
		$pratique->theme = $inputs['theme']; 
		$pratique->endroit = $inputs['endroit'];
		$pratique->context = $inputs['context'];
		$pratique->users_id = $inputs['users_id'];
        $pratique->save();
	}

	public function getPaginate($n){
		return $this->pratique
		->orderBy('exercice.created_at', 'desc')
		->paginate($n);
	}

	public function getPratiquesByUser($idUser, $n){
		return $this->pratique->where('pratique.users_id', $idUser)
		->orderBy('pratique.created_at', 'desc')
		->paginate($n);
	}

	public function getPratiquesByIdUser($idUser){
		return $this->pratique->where('pratique.users_id', $idUser)
		->orderBy('pratique.created_at', 'desc')->get();
	}

	public function getExercicesByPratiqueId($idPratique){
		return DB::table('exercice')
		->select('exercice.principe', 'pratique_exercice.time', 'exercice.id', 'exercice.image', 'pratique_exercice.nbJoueurs', 'pratique_exercice.description',
		'exercice.isMatch', 'exercice.created_at', 'pratique_exercice.observations', 'typesexcercice.nom AS typeExerciceNom')
		->leftJoin('typesexcercice', 'typesexcercice.id' , '=', 'exercice.typesexcercice_id')
		->join('pratique_exercice', 'exercice.id', '=', 'pratique_exercice.exercice_id')
		->join('pratique', 'pratique.id', '=', 'pratique_exercice.pratique_id')
		->where('pratique.id', '=', $idPratique)
		->get();
	}

	public function getIdExercicesByPratqueId($idPratique){
		return DB::table('exercice')
		->select('exercice.id')
		->join('pratique_exercice', 'exercice.id', '=', 'pratique_exercice.exercice_id')
		->join('pratique', 'pratique.id', '=', 'pratique_exercice.pratique_id')
		->where('pratique.id', '=', $idPratique)
		->get();
	}

	public function store(Array $inputs){
		$pratique = new Pratique;	
		$this->save($pratique, $inputs);
		$lstExercicesAdded = collect();
		//enregistrer les exercices
		if(isset($inputs['lstExercices'])){
			$lstImagesById = $inputs['lstImagesById'];
			$lstExercices = $inputs['lstExercices'];
			foreach($lstExercices as $exerciceItem){
				$exercice = json_decode($exerciceItem, true);
				$exeCreated = null;	
				//valider si c'est un nouvel exercice	
				if(isset($exercice['newAdded'])){	
					$exercice['image'] = isset($exercice['isGame']) ? '' : $lstImagesById->get('image_' . $exercice['index']);
					$exercice['users_id'] = $inputs['users_id'];
					$exeCreated = $this->exerciceRepository->store($exercice);
				}else{
					$exeCreated = $exercice;
				}
				
				//attacher l'exercice avec la pratique
				if($exeCreated != null){
					$array = array('description' => $exeCreated['description'], 'time' => $exeCreated['time'], 'exercice_id' => $exeCreated['id'],
							'observations' => $exeCreated['observations'], 'pratique_id' => $pratique->id, 'nbJoueurs' => $exeCreated['nbJoueurs']);
					$this->pratiqueExerciceRepository->store($array);
				}

				$lstExercicesAdded->push($exeCreated);
			}
		}

		$pratique->exercices = $lstExercicesAdded;

		return $pratique;
	}

	public function getById($id){
		return $this->pratique->findOrFail($id);
	}

	public function update($pratique,  Array $inputs){
		$lstExercicesAdded = collect();

		//obtenir tous les id d'exercices de la pratique
		$lstExercicesPratique = $this->getIdExercicesByPratqueId($pratique->id);

		//enregistrer les exercices
		if(isset($inputs['lstExercices'])){
			$lstImagesById = $inputs['lstImagesById'];
			$lstExercices = $inputs['lstExercices'];

			//supprimer les exercices 
			foreach ($lstExercicesPratique as $exerciceId) {
				$exerciceFinded = false;
				foreach($lstExercices as $exerciceItem){
					$exercice = json_decode($exerciceItem, true);

					//vérifier si ce n'est pas un nouveau exercice	
					if(!isset($exercice['newAdded']) && $exercice['id'] == $exerciceId->id){
						$exerciceFinded = true;
						break;
					}
				}

				if(!$exerciceFinded){
					$this->pratiqueExerciceRepository->deleteByIdExercice($exerciceId);
				}
			}	
			
			//ajouter les nouveaux exercices
			foreach($lstExercices as $exerciceItem){
				$exercice = json_decode($exerciceItem, true);
				$exeCreated = $exercice;

				//ajouter seulement les nouveaux exercices
				if(isset($exercice['newAdded'])){	
					$exercice['image'] = isset($exercice['isGame']) ? '' : $lstImagesById->get('image_' . $exercice['index']);
					$exercice['users_id'] = $inputs['users_id'];
					$exeCreated = $this->exerciceRepository->store($exercice);

					//attacher l'exercice avec la pratique
					$array = array('description' => $exeCreated['description'], 'time' => $exeCreated['time'], 'exercice_id' => $exeCreated['id'],
							'observations' => $exeCreated['observations'], 'pratique_id' => $pratique->id, 'nbJoueurs' => $exeCreated['nbJoueurs']);
					$this->pratiqueExerciceRepository->store($array);				
				}

				$lstExercicesAdded->push($exeCreated);
			}
		}

		$this->save($pratique, $inputs);
		$pratique->exercices = $lstExercicesAdded;
		return $pratique;
	}

	public function destroy($id){
		//supprimer les dépendances
		$this->pratiqueExerciceRepository->deleteByIdPratique($id);
		//supprimer la pratique
		DB::table('pratique')->where('id', '=', $id)->delete();
	}


	//ROUTES TESTS
	public function getTest($id){
		return $lstExercicesPratique = $this->getIdExercicesByPratqueId($id);
	}
}