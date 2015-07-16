<?php 
namespace App\Http\controllers\Home;

use Auth;
use Validator;
use TelsEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// use App\Http\Controllers\Foundation\Tels_eventCtr;



class ApplicationController extends Controller{
	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	var_dump(Auth::guest());
    	exit();
    	$this->middleware('guest', ['except' => 'getLogout']);
        // if(Auth::check()){
        // 	return redirect('/')->with('message','로그인을 해주세요');
        // }
    }

	public function getIndex () 
	{
		return view('home.application');
	}

	/**
	 * 총무를 신청합니다.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postIndex (Request $request)
	{
		
		if($user = Auth::user())
		{

			$event_info = array();
			$tel_id = null;
			$user_id = $user->getAuthIdentifier();

			// 요청 값을 확인 한다.
			$validator = $this->applicationValidator($request->all());
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

	protected function applicationValidator(array $data)
	{
		return Validator::make($data, [
            'tel_id' => 'numeric',
        ]);
	}



	
}