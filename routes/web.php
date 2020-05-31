<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//OUT OF THE BOX ROUTES
Route::get('/', 'ExerciceController@index');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//CUSTOM ROUTES APP
Route::get('/types-exercices', 'TypesExerciceController@getAll');
Route::get('/objectifs', 'ObjectifController@getAll');
Route::get('/exercice/type/{n}/{urlNom}', 'ExerciceController@type')->name('exercice.type');
Route::get('/exercice/objectifs/{objectif}', 'ExerciceController@getByObjectif')->name('exercice.objectifs');
Route::get('/exercice/{exercice}/{name}', 'ExerciceController@show')->name('exercice.show');

//ROUTES AVEC AUTH
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/print-pdf/{n}', 'ExerciceController@printPDF');

    //EXERCICE ROUTES
    Route::get('/exercice/create', 'ExerciceController@create')->name('exercice.create');
    Route::get('/exercice/{exercice}/edit', 'ExerciceController@edit')->name('exercice.edit');  
    Route::get('/exercice/get-exercices-by-user', 'UserController@getExercicesByUser');
    Route::get('/exercice/images', 'ExerciceController@getImagesExerciceUser')->name('exercice.images');
    Route::post('/exercice/update', 'ExerciceController@updateExercice');
    Route::post('/exercice/create', 'ExerciceController@createExercice');

    //SEANCES ROUTES
    Route::get('/seance/create', 'PratiquesController@create')->name('seance.create');
    Route::get('/seance/{seance}/edit', 'PratiquesController@edit')->name('seance.edit');
    Route::post('/seance/update', 'PratiquesController@updateSeance');
    Route::post('/seance/create', 'PratiquesController@createSeance');

    //USER ROUTES
    Route::get('/user/exercices', 'UserController@getExercices')->name('user.exercices');
    Route::get('/user/get-seances-by-user', 'UserController@getSeancesByUser')->name('user.seances');
    Route::get('/user/services', 'UserController@getServices')->name('user.services');

    //ROUTE OUTIL DESIGNER
    Route::get('/create-exercice', 'CreateExercice@getPage');
});

//ROUTES resource
Route::resource('exercice', 'ExerciceController')->except(['store', 'update', 'edit', 'create', 'show']);
Route::resource('types-exercice', 'TypesExerciceController');
Route::resource('seance', 'PratiquesController')->except(['store', 'update', 'edit']);

//ROUTES TESTS
Route::get('/seance/get-id-exercices/{id}', 'PratiquesController@getIdExercices');


//TODO supprimer tout ça
Route::get('/pratique/{n}', function ($n) {
    return view('pratique')->withNumero($n); 
})->where('n', '[0-9]+');

