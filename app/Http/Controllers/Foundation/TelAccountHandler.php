<?php

namespace App\Http\controllers\Foundation;

use App\Model\M_TelAccount;
use Illuminate\Http\Request;

/**
 * tels_event는 해당 고시원에서만 표시가 됨.
 */
class TelAccountHandler
{
    public function insert($tel_id, $user_id, $date, $action, $price, $content)
    {
        return M_TelAccount::create([
            'tel_id'    => $tel_id
            , 'user_id' => $user_id
            , 'date'    => $date
            , 'action'  => $action
            , 'price'   => $price
            , 'content' => $content
        ]);
    }
}
