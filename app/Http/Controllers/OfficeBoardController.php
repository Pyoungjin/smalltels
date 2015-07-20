<?php 
namespace App\Http\Controllers;

// use Auth;
// use Validator;
// use Request;

use Office;
use User;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\OfficeAccountTrait;




class OfficeBoardController extends Controller{

    // use OfficeAccountTrait;

	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');

    	User::start();
    	Office::start();

    }

    public function getIndex()
    {
    	return view('office.board');
    }





	
}