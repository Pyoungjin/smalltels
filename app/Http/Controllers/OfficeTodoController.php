<?php 
namespace App\Http\Controllers;

use Validator;
use Request;

use Office;
use User;
use STDate;

use OTodo;

use App\Model\M_TelRTodo;

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

        $standard_date = $this->standardDate(Request::input('target_m'), Request::input('target_d'));

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

    // public function postComplate()
    // {
    //     if(!OTodo::updateComplate())
    //     {
    //         return redirect()->back()->with('message','failed : '.'complate update');
    //     }

    //     return redirect()->back()->with(
    //         'message','sucessed :'.'등록되었습니다.'
    //         );
    // }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [

            ]);
    }

    private function standardDate($standard_month, $standard_date)
    {
        $standard_year = date('Y');
        $current_month = date('m');

        if($standard_month < $current_month)
        {
            $standard_year += 1;
        }

        return date_create($standard_year.'-'.$standard_month.'-'.$standard_date);
    }


}