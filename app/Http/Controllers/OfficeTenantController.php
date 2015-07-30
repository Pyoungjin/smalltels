<?php 
namespace App\Http\Controllers;


use Request;

use Office;
use User;
use OTenant;

use App\Http\Controllers\Controller;



class OfficeTenantController extends Controller{

	/**
	 * [__construct description]
	 */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function getIndex()
    {
    	return view('office.tenant');
    }

    public function postAddTenant()
    {
        $validator = OTenant::chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        if(!OTenant::addTenant())
        {
            return redirect()->back()->with('message','failed : '.'Tenant addTenant');
        }

        return redirect()->back()->with('message','successed :'.'ATenant addTenant');
    }


	
}