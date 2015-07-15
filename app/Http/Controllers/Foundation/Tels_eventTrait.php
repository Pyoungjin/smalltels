<?php

namespace App\Http\controllers\Foundation;

use App\Model\Tels_event;
use Illuminate\Http\Request;

/**
 * tels_event는 해당 고시원에서만 표시가 됨.
 */
trait Tels_eventTrait
{
    public function insertTels_event($tels_list_id , $user_id , $event_contents)
    {
        return Tels_event::create([
            'tels_id' => $tels_list_id,
            'user_id' => $user_id,
            'event_contents' => $event_contents
        ]);
    }

    /**
     * 나중에 실험 해봐야됨.
     * @param  int    $tels_list_id [description]
     * @param  string $address      [description]
     * @return [type]               [description]
     */
    public function updateTelsAddress($tels_list_id, $address)
    {
        $tmp_tels = Tels_event::find($tels_list_id);
        $tmp_tels->address = $address;
        return $tmp_tels->save();
    }

    /*
        요소 : 
         - 이벤트 등록자(registrant)
         - 이벤트 타입(type)
            : 001 / 총무 신청 
         - 이벤트 관계자(member) 
         - 이벤트 내용(content) 
     */
    public function setEvent_contents(array $event){
        return json_encode($event);
    }
}
