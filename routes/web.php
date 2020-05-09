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
Route::get('/exercices/get-exercices-by-user', 'UserController@getExercicesByUser');
Route::get('/exercice/type/{n}', 'ExerciceController@type')->name('exercice.type');
Route::get('/exercice/objectifs/{objectif}', 'ExerciceController@getByObjectif')->name('exercice.objectifs');;

//ROUTES AVEC AUTH
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/print-pdf/{n}', 'ExerciceController@printPDF');
    Route::get('/exercice/create', 'ExerciceController@create')->name('exercice.create');
    Route::get('/exercice/{exercice}/edit', 'ExerciceController@edit')->name('exercice.edit');
    Route::post('/exercice/update', 'ExerciceController@updateExercice');
    Route::post('/exercice/create', 'ExerciceController@createExercice');
    Route::get('/user/exercices', 'UserController@getExercices')->name('user.exercices');
});

//ROUTES resource
Route::resource('exercice', 'ExerciceController')->except(['store', 'update', 'edit', 'create']);
Route::resource('types-exercice', 'TypesExerciceController');

//TODO supprimer tout ça
Route::get('/create-exercice', 'CreateExercice@getPage');
Route::get('/exercice/{n}', 'GetExercice@show')->where('n', '[0-9]+');
Route::get('/pratique/{n}', function ($n) {
    return view('pratique')->withNumero($n); 
})->where('n', '[0-9]+');

