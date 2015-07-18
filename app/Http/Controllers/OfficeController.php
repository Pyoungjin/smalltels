<?php 
namespace App\Http\Controllers;

use Auth;
use Validator;
// use TelsEvent;
use TelsList;
// use TelStaffs;
use Request;
use Office;
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

    	TelsList::telsList(
    		Auth::user()->getAuthIdentifier()
    		);

    	Office::chkPermission();

    }

    public function getBoard($tel_id)
    {
    	return view('office.board');
    	// var_dump($tel_id);
    	// exit();
    }

    // public function getIndex($)
    // {
    // 	// return view('home');
    // 	var_dump($tel_id);
    // 	var_dump($option);
    // 	exit();
    // }

	// public function getApplication () 
	// {
	// 	return view('home.application');
	// }

	/**
	 * 총무를 신청합니다.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */





	
}