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


Route::get('/phpinfo', function () {

	return view('PHPInfo');
});

Route::get('/', function () {
	$this->middleware('guest', []);
	// if(Auth::check()){
	// 	return redirect('/home');
	// }
    return view('welcome');
});

// Route::post('/auth/login', function () {
// 	var_dump(Re)
// });
Route::controller('/auth', 'Auth\AuthController');

Route::controller('/home', 'HomeController');

// Route::controller('/office/{tel_id}','OfficeController');
Route::group(['prefix' => '/office/{tel_id}'], function () {
	// response()->header('Content-Type', 'text/html; charset=UTF-8');
	Route::controller('board',	'OfficeBoardController');
	Route::controller('account','OfficeAccountController');
	Route::controller('todo',	'OfficeTodoController');
	Route::controller('room',	'OfficeRoomController');
	Route::controller('tenant',	'OfficeTenantController');
});

Route::get('/test',function() {

	// return view('welcome');
	// var_dump('123');
	// exit();
	return view('welcome');
});