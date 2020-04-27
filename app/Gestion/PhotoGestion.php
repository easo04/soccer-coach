<?php 

namespace App\Gestion;

use Illuminate\Support\Str;

class PhotoGestion
{

    public function save($imageExercice)
	{
		$nomImage = null;
		if($imageExercice->isValid()){
			$chemin = config('images.path');

			$extension = $imageExercice->getClientOriginalExtension();

			do {
				$random = Str::random(10);
				$nom = $random . '.' . $extension;
				$nomImage = $nom;
			} while(file_exists($chemin . '/' . $nom));

			$imageExercice->move($chemin, $nom);
		}

		return $nomImage;
	}

}