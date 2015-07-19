<?php 
namespace App\Http\Controllers;

use Auth;
use Validator;
// use Request;

use User;
use TelEvent;
use TelsList;
use TelMember;

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
		
		if(User::check())
		{

			$event_info = array();
			$tel_id = $request->input('tel_id');
			// $user_id = $user->getAuthIdentifier();

			// 요청 값을 확인 한다.
			$validator = Validator::make($request->all(), [
	            'tel_id' => 'numeric',
	        ]);
	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }
			
 			$event_info['registrant'] = User::info('id');
 			$event_info['type'] = '001';
 			$event_info['member'] = array( 0 => User::info('id'));
 			$event_info['contents'] = null;

	        if(!TelEvent::insertTelEvent($tel_id, User::info('id') , TelEvent::setEvent_contents($event_info))){
	        	return redirect('/home')->with('message','총무신청 중 오류발생');
	    	}
	    	return redirect('/home')->with('message','총무신청이 완료되었습니다요.zz');
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
		
		if(User::check())
		{
		// 요청 값을 확인 한다.

			$validator = Validator::make($request->all(), [
	            'name' => 'required|max:30',
	            'phone' => 'min:9',
	        ]);

	        if ($validator->fails()) {
	            $this->throwValidationException(
	                // $request, $validator
	                $request, $validator
	            );
	        }
 
	        //고시원을 저장한다.
	        if(!($tel = TelsList::insertTels($request->all()))){
	        	return redirect('/home')->with('등록 오류 :'.'고시원 등록중 오류가 생겼습니다.');
	        }
	  //       var_dump($tel);
			// exit();
	        //사용자를 고시원 오너로 저장한다.
	        if(!TelMember::insertTelMember($tel->getQueueableId(), User::info('id') , 'owner'))
	        {
	        	return redirect('/home')->with('등록 오류 :'.'고시 맴버 등록중 오류가 생겼습니다.');
	        }
	        //리다이렉트 시킨다.
	        return redirect('/home')->with('message', $tel->name.' 이(가) 등록되었습니다.');
    	}

    	return redirect('/')->with('message','로그인이 필요합니다.');
	}



	
}