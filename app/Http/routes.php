<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	if(Auth::check()){
		return redirect('/home');
	}
    return view('welcome');
});

Route::get('/phpinfo', function () {
	return view('PHPInfo');
});

Route::controller('/auth', 'Auth\AuthController');

Route::controller('/home', 'HomeController');

// Route::controller('/office/{tel_id}','OfficeController');
Route::group(['prefix' => '/office/{tel_id}'], function () {
	// var_dump('123');
	// exit();
	Route::controller('board/{date?}', 'OfficeBoardController');
	Route::controller('account', 'OfficeAccountController');
});