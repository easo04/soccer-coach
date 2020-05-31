<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pratique extends Model
{
    protected $table = 'pratique';
    
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User', 'users_id');
    }

    public function exercices()
	{
		return $this->belongsToMany('App\Exercice');
	} 
}
