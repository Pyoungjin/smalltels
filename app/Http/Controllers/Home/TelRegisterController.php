<?php 
namespace App\Http\controllers\Home;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\Foundation\Tels_listTrait;
use App\Http\Controllers\Foundation\Tels_staffTrait;


class TelRegisterController extends Controller{

	use Tels_listTrait,Tels_staffTrait;
	/**
	 * [__construct description]
	 */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);//이걸쓰면 로그인 되도 무조건 /home으로 보
        if(Auth::check()){
        	return redirect('/')->with('message','로그인을 해주세요');
        }
    }

	public function getIndex () 
	{
		return view('home.tel_register');
	}

	/**
	 * 새로운 고시원 등록합니다.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postIndex (Request $request)
	{
		
		if($user = Auth::user())
		{
		// 요청 값을 확인 한다.
			$validator = $this->goValidator($request->all());
	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }
 
	        //고시원을 저장한다.
	        $tels = $this->insertTels($request->all());
	        //사용자를 고시원 오너로 저장한다.
	        $staff = $this->insertTels_staff($tels->getQueueableId(), $user->getAuthIdentifier() , 'owner');
	        //리다이렉트 시킨다.
	        return redirect('/home')->with('message',$tels->__get('name').' 이(가) 등록되었습니다.');
    	}

    	return redirect('/')->with('message','로그인이 필요합니다.');
	}

	protected function goValidator(array $data)
	{
		return Validator::make($data, [
            'name' => 'required|max:30',
            'phone' => 'min:9',
        ]);
	}

	
}