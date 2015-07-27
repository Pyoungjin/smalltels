<?php

namespace App\Http\controllers\Foundation;

use App\Model\M_TelRTodoHistory;
use Illuminate\Http\Request;

/**
 * tels_event는 해당 고시원에서만 표시가 됨.
 */
class TelRTodoHstoryHandler
{
    public function insert($tel_id , $target_month, $content='{}')
    {
        return M_TelRTodoHistory::create([
            'tel_id'    => $tel_id,
            'target_month'  => $target_month,
            'content'   => $content
        ]);
    }

}
