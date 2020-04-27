<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    protected $table = 'exercice';
    
    public $timestamps = true;

    public function typeExercice(){
        return $this->belongsTo('App\TypesExercice', 'typesexcercice_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id');
    }

    public function variantes(){
        return $this->hasMany('App\Variante', 'exercice_id');
    }
}
