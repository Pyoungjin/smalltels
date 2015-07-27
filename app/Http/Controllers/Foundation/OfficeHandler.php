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

/**
 * 유저가 요청한 office의 정보를 가져온다.
 */
class OfficeHandler
{
    private $start = false;
    private $requsted_tel_id = null;
    private $user_permission = null;

    private $tel_info = array(
            'id' => null
            , 'name' => null
            , 'address' => null
            , 'phone' => null
            , 'created_at' => null
            , 'member'  => array()
            , 'owner'   => null
            , 'master'  => array()
            , 'staff'   => array()
        );


    /**
     * 1. 유저가 요청한 tel_id를 가져온. 
     * 2. 요청받은 tel_id를 기반으로 해당 tel의 맴버 목록을 설정한다.
     * 3. 유저가 해당 tel의 맴버인지 확인한다. => 스텝이 아니면 권한 오류
     * 4. 유저가 맞다면 
     *     4-1 tel_id를 설정한다(요청 tel_id 기준)
     *     4-2 owner, master, staff 설정을 해준다.
     *  
     */
    
    /**
     * 단위 고시원의 정보를 담은 객체를 생성하는 클래스
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
        $this->start = true;

        $this->setReqTelId();
        $this->setMember();
        $this->getPermission();

        $this->chkPermission();

        $this->setInfo();
        $this->arrangeMember();
    }

    /**
     * 요청한 유저가 고시원 정보에 접근 허가된 유저인지를구분합니다.
     * @return boolean 허가된 유저일시 true값을 반환합니다.
     */
    public function chkPermission()
    {   
        if($this->start == false) {
            $this->start();
        }
        if($this->user_permission === false) {
            echo '접속 오류 001 : '.'당신은 이고시원의 관계자 아닙니다.';
            exit();
        }

        return true;
    }

    /**
     * 고시원의 정보를 전달해줍니다.
     * @param  string $key 가져오고 싶은 정보의 키값을 전달합니다. 키값이 없으면 전체 배열을 전달합니다. 
     * @return mixed       요청한 정보를 전달합니다.
     */
    public function info($key = null)
    {   
        if($key) {
            return $this->tel_info[$key];
        }

        return $this->tel_info;
    }

    /**
     * 요청된 고시원의 id값이 무엇인지 설정합니다.
     * @return void
     */
    private function setReqTelId()
    {
        $this->requsted_tel_id = Request::route('tel_id');
    }

    /**
     * 해당 고시원과 관련 있는 유저의 정보를 배열로 가져옵니다.
     * 맴버의 id값이 배열의 키값이 됩니다.
     * @return void 
     */
    private function setMember()
    {
        // foreach (TelStaffs::staffList($this->requsted_tel_id) as $val) {
        foreach (M_TelMember::where('tel_id','=',$this->requsted_tel_id)->get()->toArray() as $val) {
            $this->tel_info['member'][$val['user_id']] = $val;
        }
    }

    /**
     * 고시원 맴버에 유저가 속해 있는지를 확인하여 $user_perission값을 설정합니다.
     * @return void [description]
     */
    private function getPermission()
    {
        $this->user_permission = array_key_exists(
            Auth::user()->getAuthIdentifier(), 
            $this->tel_info['member']
            );
    }

    // /**
    //  * $tel_info배열에 고시원 id를 세팅합니다.
    //  * @return void
    //  */
    // private function setTelsId()
    // {
    //     $this->tel_info['tel_id'] = $this->requsted_tel_id;
    // }

    /**
     * 각 맴버를 권한별로 정리합니다. 
     * @return [type] [description]
     */
    private function arrangeMember()
    {
        foreach ($this->tel_info['member'] as $val) {
            if($val['roll'] == 'owner'){
                $this->tel_info['owner'] = $val['user_id'];
            }else if($val['roll'] == 'master'){
                array_push($this->tel_info['master'], $val['user_id']);
            }else if($val['roll'] == 'staff'){
                array_push($this->tel_info['staff'], $val['user_id']);
            }
        }
    }

    private function setInfo()
    {
        foreach (M_TelsList::find($this->requsted_tel_id)->toArray() as $key => $val) {
            $this->tel_info[$key] = $val;
        }
    }


    


}
