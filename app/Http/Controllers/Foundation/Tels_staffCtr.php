<?php

namespace App\Http\controllers\Foundation;

use App\Model\Tels_staff;
use Illuminate\Http\Request;


class Tels_staffCtr
{
    public function insertTels_staff($tels_id, $user_id, $roll)
    {
        return Tels_staff::create([
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
        $tmp_staff = Tels_staff::find($tels_staff_id);
        $tmp_staff->roll = $roll;
        return $tmp_staff->save();
    }
}
