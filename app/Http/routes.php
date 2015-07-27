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
	Route::controller('board', 'OfficeBoardController');
	Route::controller('account', 'OfficeAccountController');
	Route::controller('todo', 'OfficeTodoController');

});

Route::get('/test',function() {
	$a=date_create('2015-08-1');
	$b=date_create('2015-06-30');
	$c = date_create('2015-07');
	$d = date_create(date('Y-m-d'));
	$aa = date_diff($a,$d);
	$aa1 = date_diff($b,$d);
	$aa2 = date_diff($d,$c);
	// $bb = date_diff('2015-06-01',date('Y-m-d'));
	var_dump($aa);
	// var_dump($aa->invert);
	// var_dump('||');
	// var_dump($aa1->m);
	// var_dump($aa1->invert);
	// var_dump('||');
	// var_dump($aa2->m);
	// var_dump($aa2->invert);
	// var_dump($bb);
	exit();
});