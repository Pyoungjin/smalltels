<?php

namespace App\Http\controllers\Foundation;

use App\Model\M_TelRTodo;
use Illuminate\Http\Request;

/**
 * tels_event는 해당 고시원에서만 표시가 됨.
 */
class TelRTodoHandler
{
    public function insert($tel_id , $title , $type, $interval, $last_date )
    {
        return M_TelRTodo::create([
            'tel_id'    => $tel_id,
            'title'     => $title,
            'type'      => $type,
            'interval'  => $interval,
            'last_date' => $last_date,
        ]);
    }

}
