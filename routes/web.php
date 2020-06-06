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
Route::get('/types-exercices', 'TypesExerciceController@getAll'); //API
Route::get('/objectifs', 'ObjectifController@getAll'); //API
Route::get('/exercice/type/{n}/{urlNom}', 'ExerciceController@type')->name('exercice.type');
Route::get('/exercice/objectifs/{objectif}', 'ExerciceController@getByObjectif')->name('exercice.objectifs');
Route::get('/exercice/{exercice}/{name}', 'ExerciceController@show')->name('exercice.show');

//ROUTES AVEC AUTH
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/print-pdf/{n}', 'ExerciceController@printPDF');

    //EXERCICE ROUTES
    Route::get('/exercice/create', 'ExerciceController@create')->name('exercice.create');
    Route::get('/exercice/{exercice}/edit', 'ExerciceController@edit')->name('exercice.edit');  
    Route::get('/exercice/get-exercices-by-user', 'UserController@getExercicesByUser'); //API
    Route::get('/exercice/images', 'ExerciceController@getImagesExerciceUser')->name('exercice.images'); //API
    Route::post('/exercice/update', 'ExerciceController@updateExercice'); //API
    Route::post('/exercice/create', 'ExerciceController@createExercice'); //API
    Route::get('/exercice/outil/get-variantes-and-objectifs/{id}', 'ExerciceController@getVariantesAndObjectifsByExe'); //API

    //SEANCES ROUTES
    Route::get('/seance/create', 'PratiquesController@create')->name('seance.create');
    Route::get('/seance/{seance}/edit', 'PratiquesController@edit')->name('seance.edit');
    Route::post('/seance/update', 'PratiquesController@updateSeance'); //API
    Route::post('/seance/create', 'PratiquesController@createSeance'); //API
    Route::get('/seances/get-exercice-by-seance/{id}', 'PratiquesController@getExercicesBySeanceId'); //API

    //USER ROUTES
    Route::get('/user/get-seances-by-user', 'UserController@getSeancesByUser')->name('user.seances'); //API
    Route::get('/user/services', 'UserController@getServices')->name('user.services'); //API

    //FAVORIS ROUTES
    Route::get('/favoris/get-favoris-by-user', 'FavorisController@getFavorisToAuthUser');
    Route::post('/favoris/add-favoris', 'FavorisController@addExerciceToFavoris');

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

