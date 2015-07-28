<?php 
namespace App\Http\Controllers;

use Validator;
use Request;

use Office;
use User;

use App\Http\Controllers\Controller;



class OfficeRoomController extends Controller{

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
    	return view('office.room');
    }

    // public function postRecoder()
    // {
         
    //     $validator = $this->chkValidator();
        
    //     if ($validator->fails()) {
    //         $request = Request::instance();
    //         $this->throwValidationException(
    //             $request, $validator
    //         );
    //     }

        

    //     if(!TelAccount::insert(
    //         Office::info('id')
    //         , User::info('id')
    //         , (Request::input('date'))?Request::input('date'):date("Y-m-d h:i:s")
    //         , Request::input('action')
    //         , Request::input('price')
    //         , Request::input('content')
    //         )){
    //         return redirect()->back()->with('message','failed : '.'Account Record');
    //     }

    //     return redirect()->back()->with('message','successed :'.'Account Record');
    // }

    // private function chkValidator()
    // {
    //     return Validator::make(Request::all(), [
    //             'price' => 'numeric|max:10000000000',
    //             'content' => 'max:120'
    //         ]);
    // }




	
}