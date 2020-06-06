<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favoris extends Model
{
    public $timestamps = true;

    protected $fillable = ['users_id', 'exercice_id'];
}
