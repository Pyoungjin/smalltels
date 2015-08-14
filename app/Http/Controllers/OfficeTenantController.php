<?php 
namespace App\Http\Controllers;


use Request;

use Office;
use User;
use UI;
use OTenant;


use App\Http\Controllers\Controller;

use App\Model\M_TelTenant;



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
        $validator = $this->chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        if(!$this->addTenant())
        {
            return redirect()->back()->with('message','failed : '.'Tenant addTenant');
        }

        return redirect()->back()->with('message','successed :'.'ATenant addTenant');
    }

    public function getTenantDetail()
    {
        return view('office.modal.tenant_detail');
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'phone1' => 'max:4',
                'phone2' => 'max:4',
                'phone3' => 'max:4',

                'person1_phone1' => 'max:4',
                'person1_phone2' => 'max:4',
                'person1_phone3' => 'max:4',

                'person2_phone1' => 'max:4',
                'person2_phone2' => 'max:4',
                'person2_phone3' => 'max:4',

                'birth_year'    => 'numeric|max:2015|min:1900',
                'birth_month'   => 'numeric|max:12',
                'birth_day'     => 'numeric|max:31',

                'job'     => 'max:20',
                'address' => 'max:250',

                'name'    => 'max:20',
                'person1_name'    => 'max:20',
                'person2_name'    => 'max:20',
            ]);
    }

    public function addTenant()
    {
        return M_TelTenant::create([
            'tel_id'      => Office::info('id'),
            'name'        => Request::input('name'),
            'phone1'      => Request::input('phone1'),
            'phone2'      => Request::input('phone2'),
            'phone3'      => Request::input('phone3'),
            'birth_year'  => Request::input('birth_year'),
            'birth_month' => Request::input('birth_month'),
            'birth_day'   => Request::input('birth_day'),
            'gender'      => Request::input('gender'),
            'job'         => Request::input('job'),
            'address'     => Request::input('address'),
            'notice'      => Request::input('notice'),

            'person1_name'   => Request::input('person1_name'),
            'person1_phone1' => Request::input('person1_phone1'),
            'person1_phone2' => Request::input('person1_phone2'),
            'person1_phone3' => Request::input('person1_phone3'),
            'person1_notice' => Request::input('person1_notice'),

            'person2_name'   => Request::input('person2_name'),
            'person2_phone1' => Request::input('person2_phone1'),
            'person2_phone2' => Request::input('person2_phone2'),
            'person2_phone3' => Request::input('person2_phone3'),
            'person2_notice' => Request::input('person2_notice'),
            ]);
    }


	
}