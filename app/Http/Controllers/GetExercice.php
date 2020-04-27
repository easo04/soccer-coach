<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetExercice extends Controller
{
    public function show($n)
	{
		return view('exercice')->withNumero($n);
	}
}
