<?php 
namespace App\Http\Controllers;

use Auth;
use Validator;
use Request;

use Office;
use User;

use App\Http\Controllers\Controller;




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
    }





	
}