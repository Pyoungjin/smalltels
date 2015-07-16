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
	if(!Auth::check()){
		return redirect('/');
	}
	return view('home');
});

//고시원 등록
// Route::controller('/home/telRegister', 'Home\TelRegisterController');

//총무신청
Route::controller('/home/application', 'Home\ApplicationController');
// Route::get('/home/application', function (){
// 	return view('home.application');
// });

//smalltels사용
Route::get('/home/manual', function () {
	return view('home.manual');
});





