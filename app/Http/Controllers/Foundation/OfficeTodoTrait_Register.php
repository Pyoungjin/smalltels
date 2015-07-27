<?php

namespace App\Http\Controllers\Foundation;

use Validator;

use Auth;
use Request;

use Office;
use OTodo;

use TelRTodo;

use App\Model\M_TelRTodo;
use App\Model\M_TelRTodoHistory;


trait OfficeTodoTrait_Register
{   
    public function startForRegister()
    {
        $validator = $this->chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        if(!$this->chkTypeIntervalMatching())
        {
            return redirect()->back()->with('message','type과 interval 불일치');
        }

        $this->setLastDate();

        return TelRTodo::insert(
            Office::info('id')
            , Request::input('title')
            , Request::input('type')
            , Request::input('interval')
            , Request::input('last_date')
            );
        
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'interval' => 'numeric|max:31',
            ]);
    }

    private function chkTypeIntervalMatching()
    {
        if(($type = Request::input('type')) == 'monthly')
        {
            if(Request::input('interval') < date('t',$this->setLastDate()))
            {
                return true;
            }

        }
        else if( $type == 'weekly')
        {
            Request::input('interval') < 6;
            return true;
        }
        else if( $type == 'daily')
        {
            Request::input('interval') < 30;
            return true;
        }

        return false;

    }

    private function setLastDate()
    {   
        $year = date('Y');
        if(Request::input('month') < date('m')){
            $year++;
        }
        Request::merge(['year' => $year]);

        Request::merge(['last_date' => Request::input('year').'-'.Request::input('month').'-'.Request::input('date')]);
    }
}
?>