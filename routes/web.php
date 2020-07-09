<?php

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

Route::get('/','HomeController@index')->middleware("auth");
Route::get('/tags/{id}', 'HomeController@showtag');

Route::prefix('question')->group(function() {
  Route::get('/', 'QuestionController@index')->name('question.index');
  Route::get('/create', 'QuestionController@create');
  Route::get('/{id}', 'QuestionController@show');
  
  Route::get('/{id}/edit', 'QuestionController@edit');

  Route::post('/', 'QuestionController@store');
  Route::put('/{id}', 'QuestionController@update');
  Route::delete('/{id}', 'QuestionController@destroy');
});

Route::post('/answers/{question_id}', 'AnswerController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
