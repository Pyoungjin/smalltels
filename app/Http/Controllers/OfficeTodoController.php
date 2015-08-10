<?php 
namespace App\Http\Controllers;

use Validator;
use Request;

use Office;
use User;
use STDate;

use OTodo;

use App\Model\M_TelRTodo;
use App\Model\M_TelRTodoPerform;

use App\Http\Controllers\Controller;



class OfficeTodoController extends Controller{

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        

        // return view('office.todo')->with('view_date',$view_date);
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

        // $standard_date = $this->standardDate(Request::input('target_m'), Request::input('target_d'));
        $standard_date = date_create(Request::input('standard_date'));

        if(!M_TelRTodo::create([
            'tel_id' => Office::info('id'),
            'title'  => Request::input('title'),
            'type'   => Request::input('type'),
            'interval' => Request::input('interval'),
            'standard_date' => $standard_date->format('Y-m-d'),
            ]))
        {
            return redirect()->back()->with('message','등록실패.');
        }
        return redirect()->back()->with(
            'message','등록되었습니다. '
            .$standard_date->format('Y').'년 '.$standard_date->format('m').'월 '.$standard_date->format('d').'일 부터 시행됩니다.'
            );
    }

    public function postPerform()
    {
        if(!M_TelRTodoPerform::create([
            'rtodo_id'  => Request::input('rtodo_id'),
            'date'      => Request::input('date'),
            'user_id'   => User::info('id'),
            'state'     => 'complete',
            ]))
        {
            return redirect()->back()->with('message','입력중 오류 발생.');
        }

        return redirect()->back()->with(
            'message',
            Request::input('date')." : '".OTodo::info('rtodo_list')[Request::input('rtodo_id')]['title']."'를 완료하셨습니다."
            );
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [

            ]);
    }

    private function setWeekDay()
    {
        $current_date = date('w');

    }


}