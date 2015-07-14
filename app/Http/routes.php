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
    return view('welcome');
});

Route::get('/phpinfo', function () {
	return view('PHPInfo');
});

// Route::get('/test/{FuncName}', 'TestController@'.$FuncName);
// Route::get('/test/testFunc1', 'TestController@testFunc1');
// Route::get('/test/testFunc1', function () {
// 	return view('testview');
// });
// 

Route::controller('/auth', 'Auth\AuthController');
// Route::get('/auth/login', 'Auth\AuthController@getLogin');
// 
Route::get('/home', function () {
	return view('home');
});
Route::controller('/goRegister', 'Home\GoRegisterController');
// Route::get('/goRegister', 'Home\GoRegisterController@getIndex');
