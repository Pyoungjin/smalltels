<?php 
namespace App\Http\Controllers;


use Request;

use Office;
use User;
use ORoom;

use App\Http\Controllers\Controller;



class OfficeRoomController extends Controller{

	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function getIndex()
    {
    	return view('office.room');
    }

    public function postAddRoom()
    {
        if(!ORoom::addRoom())
        {
            return redirect()->back()->with('message','failed : '.'Room addRoom');
        }

        return redirect()->back()->with('message','successed :'.'Room addRoom');
    }
}