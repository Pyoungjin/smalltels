<?php

namespace App\Http\controllers\Foundation;

use Validator;

use User;
use Request;

// use TelsEvent;
// use TelsList;
// use TelStaffs;

use App\Model\M_TelTenant;
use App\Model\M_TelTenantNote;
use App\Model\M_TelRoom;

use Office;


/**
 * 유저가 요청한 office room의 정보를 가져온다.
 */
class OfficeTenantHandler
{

    private $start = false;
    private $tel_id = null;
    private $tenant_list = array();

    private $info = array(
        'list' => array()
        );

    private $find = array(
        );
   

    public function __construct()
    {

    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    private function start()
    {
        if($this->start)
        {
            return $this;
        }

        $this->start = true;
        $this->setTelId();

        $this->setTenantList();

        $this->setInfo();

        return $this;
    }

    /**
     * 고시원의 정보를 전달해줍니다.
     * @param  string $key 가져오고 싶은 정보의 키값을 전달합니다. 키값이 없으면 전체 배열을 전달합니다. 
     * @return mixed       요청한 정보를 전달합니다.
     */
    public function info($key = null)
    {   
        if(!$this->start)
        {
            $this->start();
        }
        if($key) {
            return $this->info[$key];
        }

        return $this->info;
        
    }

    public function find($tenant_id)
    {
        if($this->start){
            $this->find = $this->info['list'][$tenant_id];
        }else{
            $this->find = $this->findTenant($tenant_id);
            array_push($this->find, $this->setTenantRoom($tenant_id));
        }

        return $this->find;


    }

    public function count($key)
    {
        if(!$this->start)
        {
            $this->start();
        }
        if(!array_key_exists($key,$this->info))
        {
            return 'null';
        }
        return count($this->info[$key]);

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

    public function chkValidator()
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

    private function setTelId()
    {
        $this->tel_id = Office::info('id');
    }

    private function setTenantList()
    {
        
        foreach ((M_TelTenant::where('tel_id','=',$this->tel_id)->get()->toArray()) as $key => $val) {
            $this->tenant_list[$val['id']] = $val;
            array_push($this->tenant_list[$val['id']], $this->setTenantRoom($val['id']));
        }
    }

    private function setInfo()
    {
        $this->info['list'] = $this->tenant_list;
    }

    private function findTenant($tenant_id)
    {
        return M_TelTenant::find($tenant_id)->get()->toArray();
    }

    private function setTenantRoom($tenant_id)
    {
        $tmp_result = array();
        $tmp_arr = M_TelRoom::where('tenant_id','=','$tenant_id')->get()->toArray();

        $tmp_result['count'] = count($tmp_arr);
        $tmp_result['room'] = $tmp_arr;

        return $tmp_result;
    }





    


}
