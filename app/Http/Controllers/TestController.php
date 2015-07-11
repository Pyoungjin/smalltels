<?php

namespace App\Http\Controllers;

use App\TestModel;

use App\Http\Controllers\Controller;



class TestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function testFunc1()
    {
        // return view('testview');
        return view('testview', ['testData' => TestModel::all()]);
        // return $users = User::all();
    }
}
