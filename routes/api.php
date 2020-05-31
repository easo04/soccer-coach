<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/exercice', 'ExerciceController@getExerices');

//ROUTES AVEC AUTH
//Route::middleware(['auth'])->group(function () {
    //Route::post('/seance/update', 'PratiquesController@updateSeance');
    //Route::post('/seance/create', 'PratiquesController@createSeance');
//});