<?php 
namespace App\Http\controllers\Home;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Foundation\Tels_listTrait;
use App\Http\Controllers\Foundation\Tels_staffTrait;


class GoRegisterController extends Controller{

	use Tels_listTrait,Tels_staffTrait;
	/**
	 * [__construct description]
	 */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);//이걸쓰면 로그인 되도 무조건 /home으로 보
    }

	public function getIndex () 
	{
		// $tmp_user = Auth::user();
		// var_dump(Auth::getAuthIdentifier());
		// exit();
		return view('home.go_register');
	}

	public function postIndex (Request $request)
	{
		
		if($user = Auth::user())
		{
		// 요청 값을 확인 한다.
			$validator = $this->validator($request->all());
	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }
 
	        //값을 저장한다.
	        $tels = $this->insertTels($request->all());
	        // var_dump($tels->getQueueableId());
	        // var_dump($user->getAuthIdentifier());
	        $staff = $this->insertTels_staff($tels->getQueueableId(), $user->getAuthIdentifier() , 'owner');
	        // exit();
	        // var_dump($tels->id);
	        // // Auth::login($this->create($request->all()));
	        // exit();
	        //리다이렉트 시킨다.
	        return redirect('/home')->with('message',$tels->__get('name').' 이(가) 등록되었습니다.');
    	}

    	return redirect('/')->with('message','로그인이 필요합니다.');
	}

	protected function validator(array $data)
	{
		return Validator::make($data, [
            'name' => 'required|max:30',
            'phone' => 'min:9',
        ]);
	}

	
}