<?php 
namespace App\Http\Controllers;

use Validator;
use Request;
// use Route;
// use URL;

use Office;
use User;
use OAccount;

use TelAccount;

use App\Http\Controllers\Controller;



class OfficeAccountController extends Controller{

	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');

        
    	// User::start();
    	// Office::start();


    }

    public function getIndex()
    {
        OAccount::start();
    	return view('office.account');
    }

    public function postRecoder()
    {
         
        $validator = $this->chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        if(!OAccount::insert(
            Office::info('id')
            , User::info('id')
            , $this->setDate()
            , Request::input('action')
            , Request::input('price')
            , Request::input('content')
            )){
            return redirect()->back()->with('message','failed : '.'Account Record');
        }

        return redirect()->back()->with('message','기록하였습니다.');
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'price' => 'numeric|max:10000000000',
                'content' => 'max:120'
            ]);
    }

    private function setDate()
    {
        if(($req_date = Request::input('date')) && ($req_date != date('Y-m')))
        {   
            // $last_day = date('t',$req_date);
            $last_day = date_create($req_date)->format('t');
            $tmp_date = date_create($req_date.'-'.$last_day)->format('Y-m-d');
        }else{
            $tmp_date = date("Y-m-d h:i:s");
        }

        return $tmp_date;
    }




	
}