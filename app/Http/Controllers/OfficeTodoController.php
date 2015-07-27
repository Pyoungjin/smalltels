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
            // var_dump(Office::info());
        // exit();
    }

    public function getIndex()
    {

        OTodo::start();
        return view('office.todo');
    }

    public function postRTodo()
    {
        
        if(!OTodo::startForRegister()){
            return redirect()->back()->with('message','기록실패');
        }

        return redirect()->back()->with(
            'message','등록되었습니다. '
            .Request::input('year').'년 '.Request::input('month').'월 '.Request::input('date').'일 부터 시행됩니다.');
    }


}