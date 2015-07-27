<?php 
namespace App\Http\Controllers;

use Validator;
use Request;
// use Route;
// use URL;

use Office;
use User;
use OTodo;

use TelRTodo;

use App\Http\Controllers\Controller;



class OfficeTodoController extends Controller{

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');

        
        User::start();
        Office::start();
        



    }

    public function getIndex()
    {
        OTodo::start();
        return view('office.todo');
    }

    public function postRTodo()
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

        if(!TelRTodo::insert(
            Office::info('id')
            , Request::input('title')
            , Request::input('type')
            , Request::input('interval')
            , Request::input('last_date')
            )){
            return redirect()->back()->with('message','기록실패');
        }

        return redirect()->back()->with(
            'message','등록되었습니다. '
            .Request::input('year').'년 '.Request::input('month').'월 '.Request::input('date').'일 부터 시행됩니다.');
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