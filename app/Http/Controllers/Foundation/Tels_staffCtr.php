<?php

namespace App\Http\controllers\Foundation;

use App\Model\Tels_staff as M_TelsStaff;
use Illuminate\Http\Request;


class Tels_staffCtr
{
    public function insertTels_staff($tels_id, $user_id, $roll)
    {
        return M_TelsStaff::create([
            'tels_id' => $tels_id,
            'user_id' => $user_id,
            'roll' => $roll
        ]);
    }

    /**
     * 나중에 실험 해봐야됨.
     * @param  int    $tels_list_id [description]
     * @param  string $address      [description]
     * @return [type]               [description]
     */
    public function updateTelsRoll($tels_staff_id, $roll)
    {
        $tmp_staff = M_TelsStaff::find($tels_staff_id);
        $tmp_staff->roll = $roll;
        return $tmp_staff->save();
    }

    // public function chkTelsOfUser($user_id,$tel_id)
    // {
    //     if(!count(M_TelsStaff::where('user_id','=',$user_id)->where('tels_id','=',$tel_id)->get()->toArray()))
    //     {
    //         echo '접속 오류 : '.'당신이 소속된 고시원이 아닙니다.';
    //         exit();
    //     }
    // }

    // public function staffList($tel_id)
    // {
    //     return M_TelsStaff::where('tels_id','=',$tel_id)->get()->toArray();
    // }

    // public function telsList($user_id)
    // {
    //     return M_TelsStaff::where('user_id','=',$user_id)->get()->toArray();
    // }
}
