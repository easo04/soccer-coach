<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateExercice extends Controller
{
  public function getPage(){
		return view('create-exercice');
	}
}
