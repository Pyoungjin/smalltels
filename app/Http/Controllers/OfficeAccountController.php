<?php 
namespace App\Http\Controllers;

use Validator;
use Request;
// use Route;
// use URL;

use Office;
use User;

use TelAccount;

use App\Http\Controllers\Controller;



class OfficeAccountController extends Controller{

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

        if(!TelAccount::insert(
            Office::info('id')
            , User::info('id')
            , Request::input('action')
            , Request::input('price')
            , Request::input('content')
            )){
            return redirect()->back()->with('message','기록실패');
        }

        return redirect()->back()->with('message','기록되었습니다.');
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'price' => 'numeric|max:10000000000',
                'content' => 'max:120'
            ]);
    }




	
}