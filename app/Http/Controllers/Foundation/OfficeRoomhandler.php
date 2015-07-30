<?php

namespace App\Http\controllers\Foundation;

use Validator;

use User;
use Request;

// use TelsEvent;
// use TelsList;
// use TelStaffs;

use App\Model\M_TelRoom;
use App\Model\M_TelRoomNote;

use Office;


/**
 * 유저가 요청한 office room의 정보를 가져온다.
 */
class OfficeRoomHandler
{

    private $start = false;
    private $tel_id = null;
    private $room_list = array();

    private $info = array(
        'list' => array()
        );

   

    public function __construct()
    {

    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        if($this->start)
        {
            return $this;
        }

        $this->start = true;
        $this->setTelId();
        $this->setRoomList();

        $this->setInfo();

        return $this;
    }

    /**
     * 고시원의 정보를 전달해줍니다.
     * @param  string $key 가져오고 싶은 정보의 키값을 전달합니다. 키값이 없으면 전체 배열을 전달합니다. 
     * @return mixed       요청한 정보를 전달합니다.
     */
    public function info($key = null)
    {   
        if(!$this->start)
        {
            $this->start();
        }
        if($key) {
            return $this->info[$key];
        }

        return $this->info;
    }

    public function count($key)
    {
        if(!$this->start)
        {
            $this->start();
        }
        if(!array_key_exists($key,$this->info))
        {
            return 'null';
        }
        return count($this->info[$key]);

    }

    public function addRoom()
    {
        $order = Request::input('order');
        $tmp_result = array();
        $validator = $this->chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        for ($i = $order; $i ; $i--) { 
            array_push($tmp_result, M_TelRoom::insert([
                'tel_id' => Office::info('id'),
                'state' => 'empty'
                ]));
        }

        if(count($tmp_result) != $order){
            return false;
        }

        return true;
    }
    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'order' => 'numeric|max:100',
            ]);
    }

    private function setTelId()
    {
        $this->tel_id = Office::info('id');
    }

    private function setRoomList()
    {
        foreach (M_TelRoom::where('tel_id','=',$this->tel_id)->get() as $key => $val) {
            $this->room_list[$val['id']] = $val;
        }
    }

    private function setInfo()
    {
        $this->info['list'] = $this->room_list;
    }





    


}
