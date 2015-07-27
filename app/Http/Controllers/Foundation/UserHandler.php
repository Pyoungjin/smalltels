<?php

namespace App\Http\controllers\Foundation;

use Auth;
use Request;
// use TelsEvent;
// use TelsList;
// use TelStaffs;

use App\Model\M_TelsList;
use App\Model\M_TelMember;
// use Illuminate\Http\Request;


class UserHandler
{
    private $start = false;
    // private $requsted_user_id = null;
    private $permission = null;

    private $user_info = array(
            'id'   => null
            , 'office_list_index' => array()
            , 'office_list' => array()
        );


    /**
     * 1. 로그인 여부를 판단한다. => 로그인이 안되있으면 로그인 화면으로 보낸다.
     * 2. 유저가 속한 오피스의 리스트를 가지고 온다.
     */
    
    /**
     * 단위 유저의 정보를 담은 객체를 생성하는 클래스
     */
    public function __construct()
    {
        


    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        

        if($this->start){
            return true;
        }

        $this->chkPermission();

        $this->start = true;
        
        $this->setUserId();
        // $this->setOfficeRowList();
        $this->setOfficeListIndex();
        $this->arrangeOfficeList();
    }

    /**
     * 유저의 정보를 전달해줍니다.
     * @param  string $key 가져오고 싶은 정보의 키값을 전달합니다. 키값이 없으면 전체 배열을 전달합니다. 
     * @return mixed       요청한 정보를 전달합니다.
     */
    public function info($key = null)
    {   
        if($key) {
            return $this->user_info[$key];
        }

        return $this->user_info;
    }

    public function check()
    {
        $this->start();
        return Auth::check();
    }

    /**
     * 유저가 로그인 상태인지를 확인합니다. 
     * 단순 확인 뿐이므로 리다이렉트는 미들웨어($this->middleware('auth'))를 사용해 줘야합니다. 
     * @return void
     */
    private function chkPermission()
    {
        if(!Auth::check()){
            echo '접속오류11 : '.' 로그인이 되어있지않습니다.';
            // exit();
        }

        $this->permission = Auth::check();
    }

    private function setUserId()
    {
        $this->user_info['id'] = Auth::user()->getAuthIdentifier();
    }

    // private function setOfficeRowList()
    // {
    //     foreach (TelStaffs::telsList($this->user_info['user_id']) as $val) {
    //         $this->user_info['office_row_list'][$val['tels_id']] = $val;
    //     }
    // }

    private function setOfficeListIndex()
    {
        // foreach ($this->user_info['office_row_list'] as $val) {
        foreach (M_TelMember::where('user_id', '=', $this->user_info['id'])->get()->toArray() as $val) {
            array_push($this->user_info['office_list_index'], $val['tel_id']);
        }
    }

    private function arrangeOfficeList()
    {
        foreach ($this->user_info['office_list_index'] as $val) {
            array_push($this->user_info['office_list'], M_TelsList::find($val)->toArray());
        }

    }




    


}
