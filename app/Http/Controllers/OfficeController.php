<?php 
namespace App\Http\Controllers;

use Auth;
use Validator;
// use TelsEvent;
use TelsList;
// use TelStaffs;
use Request;
use Office;
use User;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Http\RedirectResponse;




class OfficeController extends Controller{

	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');

    	User::start();
    	Office::start();

    }

    public function getBoard($tel_id)
    {
    	return view('office.board');
    	// var_dump($tel_id);
    	// exit();
    }





	
}