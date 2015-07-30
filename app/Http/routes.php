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
	// response()->header('Content-Type', 'text/html; charset=UTF-8');
	Route::controller('board',	'OfficeBoardController');
	Route::controller('account','OfficeAccountController');
	Route::controller('todo',	'OfficeTodoController');
	Route::controller('room',	'OfficeRoomController');
	Route::controller('tenant',	'OfficeTenantController');
});

Route::get('/test',function() {

	$a = array(
		1 => array('a','b'),
		2 => array('er','wr')
		);
	$g = array(
		1 => array('a','b'),
		2 => array('er','wr')
		);
	$b = array(
		2 => array('a','b'),
		4 => array('er','wr')
		);
	$c = array(
		1 => array('a','c'),
		2 => array('er','wr')
		);
	$d = array(
		1 => array('a','b','c'),
		2 => array('er','wr')
		);
	$e = array(
		'1',
		'2'
		);
	$f = array(
		'1',
		'2'
		);
	// var_dump();
	var_dump($e == $f);
	// var_dump(array_diff($a, $c));
	// var_dump(array_diff($a, $d));


	exit();
});