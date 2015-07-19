<?php

namespace App\Http\controllers\Foundation;

use App\Model\Tels_list as M_TelsList;
use Illuminate\Http\Request;

use TelStaffs;


class Tels_listCtr
{

    private $list = array();    
    public function insertTels(array $data)
    {
        return M_TelsList::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone']
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
        $tmp_tels = M_TelsList::find($tels_list_id);
        $tmp_tels->address = $address;
        return $tmp_tels->save();
    }

    /**
     * primary_key 값을 기준으로 해당 정보를 찾아 배열로 리턴해줍니다.
     * @param  [type] $tel_id [description]
     * @return [type]         [description]
     */
    public function findToArray($tel_id)
    {
        return M_TelsList::find($tels_id)->toArray();
    }

    public function setTelsListWithUserId($user_id)
    {
        $tmp_list = M_TelsList::find($user_id)->telsList->toArray();
        foreach ($tmp_list as $val) {
            // $tmp_tel_info = null;
            // $tmp_tel_info = M_TelsList::find($val['tels_id'])->toArray();
            // array_push($this->list,$tmp_tel_info);
            array_push($this->list,M_TelsList::find($val['tels_id'])->toArray());
        }
    }

    public function telsList($user_id = null)
    {
        if(!is_null($user_id)){
            $this->setTelsListWithUserId($user_id);
        }

        return $this->list;
    }
        
}
