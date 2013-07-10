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


Route::model('user', 'User');
Route::get('profile/{user}', function(User $user){
    //
});

#Route::get('users', 'UserController@getIndex');

Route::get('users', function(){
    $users = User::all();
    return View::make('users')->with('users', $users);
});
Route::get('user', array('before' => 'old', function(){
    return 'You are over 200 years old!';
}));
Route::get('user/{id}', function($id){
    return 'User '.$id;
});
Route::get('user/{id}/{name}', function($id, $name){
    return 'User '.$name; 
})->where(array('id' => '[0-9]+', 'name' => '[a-z]+'));

Route::get('user/profile/1', array('as' => 'profile', function(){
    //
}))->where(array('id' => '[0-9]+', 'name' => '[a-z]+'));