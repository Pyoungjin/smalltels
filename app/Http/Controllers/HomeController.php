<?php 
namespace App\Http\Controllers;

use Auth;
use Validator;
use User;
// use Office;

use TelsEvent;
use TelsList;
use TelStaffs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// use App\Http\Controllers\Foundation\Tels_eventCtr;



class HomeController extends Controller{

	public $tels_list = array();
	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');
    	// $user = Auth::user();
    	User::start();
    	// Office::start();
    	// var_dump($user->getAuthIdentifier());
    	// exit();
    }

    public function getIndex()
    {
    	return view('home');
    }

	public function getApplication () 
	{
		return view('home.application');
	}

	/**
	 * 총무를 신청합니다.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postApplication(Request $request)
	{
		
		if($user = Auth::user())
		{

			$event_info = array();
			$tel_id = null;
			$user_id = $user->getAuthIdentifier();

			// 요청 값을 확인 한다.
			$validator = Validator::make($request->all(), [
	            'tel_id' => 'numeric',
	        ]);
	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }

			$tel_id = $request->input('tel_id');
			
 			$event_info['registrant'] = $user_id;
 			$event_info['type'] = '001';
 			$event_info['member'] = array( 0 => $user_id);
 			$event_info['contents'] = null;

	        if($tel_id && TelsEvent::insertTels_event($tel_id, $user_id , TelsEvent::setEvent_contents($event_info))){
	        	return redirect('/home')->with('message','총무신청이 완료되었습니다요.zz');
	    	}
    	}

    	return redirect('/')->with('message','로그인이 필요합니다.');
	}

	public function getTelRegister () 
	{
		return view('home.tel_register');
	}

	/**
	 * 새로운 고시원 등록합니다.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postTelRegister (Request $request)
	{
		
		if($user = Auth::user())
		{
		// 요청 값을 확인 한다.
			$validator = Validator::make($request->all(), [
	            'name' => 'required|max:30',
	            'phone' => 'min:9',
	        ]);
	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }
 
	        //고시원을 저장한다.
	        $tel = TelsList::insertTels($request->all());
	        //사용자를 고시원 오너로 저장한다.
	        $staff = TelStaffs::insertTels_staff($tel->getQueueableId(), $user->getAuthIdentifier() , 'owner');
	        //리다이렉트 시킨다.
	        return redirect('/home')->with('message',$tel->name.' 이(가) 등록되었습니다.');
    	}

    	return redirect('/')->with('message','로그인이 필요합니다.');
	}



	
}