<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypesExercice extends Model
{
    protected $table = 'typesexcercice';
    
    public $timestamps = true;

    public function exercices() 
	{
        return $this->hasMany('App\Exercice', 'typesexcercice_id');
	}
}
