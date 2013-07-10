<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function(){
	return View::make('hello');
});
Route::get('/home', function(){
	return View::make('home');
});

Route::controller('users', 'UserController');
#Route::resource('user', 'UserController');
#Route::get('users', 'UserController@getIndex');
#Route::get('user/{id}/profile', 'UserController@showProfile');


Route::resource('photo', 'PhotoController');