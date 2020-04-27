<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExerciceRequest;
use App\Gestion\PhotoGestion;
use App\Exercice;

class AddExercice extends Controller
{
    public function getPage(){
		return view('add-exercice');
	}

	public function postInfos(ExerciceRequest $request, PhotoGestion $photogestion, Exercice $exercice){
		

		$imageExercice = $request->file('image');
		$principe = $request->input('principe');
		$sousPrincipe = $request->input('sous-principe');
		$physique = $request->input('physique');
		$time = $request->input('time');
		$nbJoueurs = $request->input('nb-joueurs');
		$description = $request->input('description');
		$observationsCoach = $request->input('observations-coach');
		$url = $request->input('url');

		$nomImage = $photogestion->save($request->file('image'));

		//$exercice = new Exercice
		$exercice->image = $nomImage;
		$exercice->principe =$principe;
		$exercice->sousPrincipe =$sousPrincipe;
		$exercice->physique =$physique;
		$exercice->time =$time ;
		$exercice->nbJoueurs =$nbJoueurs;
		$exercice->description =$description;
		$exercice->observations =$observationsCoach; 
		$exercice->url =$url; 
		$exercice->save();

		return view('exercice-details')->withPrincipe($principe)->withSousPrincipe($sousPrincipe)->withPhysique($physique)->withTime($time)->withNbJoueurs($nbJoueurs)->withDescription($description)->withObservations($observationsCoach)->withImageExercice($nomImage);
	}
}
