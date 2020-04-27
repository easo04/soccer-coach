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

//ROUTES APP
Route::resource('exercice', 'ExerciceController')->except(['store', 'update']);
Route::resource('types-exercice', 'TypesExerciceController');

//CUSTOM ROUTES APP
Route::get('/types-exercices', 'TypesExerciceController@getAll');
Route::get('exercice/type/{n}', 'ExerciceController@type');
Route::get('/customer/print-pdf/{n}', 'ExerciceController@printPDF');
Route::post('/exercice/update', 'ExerciceController@updateExercice')->middleware('auth');
Route::post('/exercice/create', 'ExerciceController@createExercice')->middleware('auth');

//TODO supprimer tout ça
Route::get('/add-exercice', 'AddExercice@getPage');
Route::post('/add-exercice', 'AddExercice@postInfos');
Route::get('/create-exercice', 'CreateExercice@getPage');
Route::get('/exercice/{n}', 'GetExercice@show')->where('n', '[0-9]+');
Route::get('/pratique/{n}', function ($n) {
    return view('pratique')->withNumero($n); 
})->where('n', '[0-9]+');

