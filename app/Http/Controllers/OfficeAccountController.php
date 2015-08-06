<?php 
namespace App\Http\Controllers;

use Validator;
use Request;
// use Route;
// use URL;
use App\Model\M_TelAccount;

use Office;
use User;
use OAccount;

use STDate;

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

        if(!M_TelAccount::create([
            'tel_id'    => Office::info('id')
            , 'user_id' => User::info('id')
            , 'date'    => $this->targetMonth(Request::input('target_month'))
            , 'action'  => Request::input('action')
            , 'price'   => Request::input('price')
            , 'content' => Request::input('content')
        ])){
            return redirect()->back()->with('message','기록에 실패하였습니다.');
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

    private function targetMonth($target_month)
    {
        if(($target_month) && ($target_month != date('Y-m')))
        {   
            $last_day = date_create($target_month)->format('t');
            return date_create($req_date.'-'.$last_day)->format('Y-m-d 23:59:59');
        }else{
            return date("Y-m-d h:i:s");
        }
    }





	
}