<?php

namespace App\Http\controllers\Foundation;

use Auth;
use Request;
// use TelsEvent;
use TelsList;
use TelStaffs;
// use App\Model\Tels_staff as M_TelsStaff;
// use Illuminate\Http\Request;


class OfficeHandler
{
    private $requsted_tel_id;
    private $user_permission;

    private $tel_info = array(
            'tels_id'   => null
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
     * 사용자가 요청한 tel_id를 설정합니다.
     */
    public function __construct()
    {
        $this->setReqTelId();
        $this->setMember();

        $this->chkPermission();

        $this->setTelsId();
        $this->arrangeMember();


    }

    public function setOffice()
    {

    }

    public function office($key = null)
    {   
        if($key){
            return $this->tel_info[$key];
        }

        return $this->tel_info;
    }


    private function setReqTelId()
    {
        $this->requsted_tel_id = Request::route('tel_id');
    }

    private function setMember()
    {
        foreach (TelStaffs::staffList($this->requsted_tel_id) as $val) {
            $this->tel_info['member'][$val['user_id']] = $val;
        }
        // $this->tel_info['member'] = TelStaffs::staffList($this->requsted_tel_id);
        // var_dump($this->tel_info['member']);
        // exit;

    }

    public function chkPermission()
    {   
        if($user_permission === null){
            $this->getPermission();
        }

        if($user_permission === false)
        {
            echo '접속 오류 : '.'당신은 이고시원의 관계자 아닙니다.';
            exit();
        }
    }

    private function getPermission()
    {
        $this->user_permission = array_key_exists(
            Auth::user()->getAuthIdentifier(), 
            $this->tel_info['member']
            );
    }

    private function setTelsId()
    {
        $this->tel_info['tels_id'] = $this->requsted_tel_id;
    }

    private function arrangeMember()
    {
        foreach ($this->tel_info['member'] as $val) {
            if($val['roll'] == 'owner'){
                $this->tel_info['owner'] = $val['id'];
            }else if($val['roll'] == 'master'){
                array_push($this->tel_info['master'], $val['id']);
            }else if($val['roll'] == 'staff'){
                array_push($this->tel_info['staff'], $val['id']);
            }
        }
    }


    


}
