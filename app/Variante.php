<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    public function exercice(){
        return $this->belongsTo('App\Exercice', 'exercice_id');
    }
}
