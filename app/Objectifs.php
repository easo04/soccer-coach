<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objectifs extends Model
{
    protected $fillable = ['nom','nom_url'];

	public function exercices()
	{
		return $this->belongsToMany('App\Exercice');
	} 
}
