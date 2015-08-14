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
        $this->arrangeTenantList();

        $this->arrangeInfo();

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

    public function tenant($tenant_id)
    {
        if(!$this->start){
            $this->start();
        }

        return $this->info['list'][$tenant_id];


    }

    private function setTelId()
    {
        $this->tel_id = Office::info('id');
    }

    private function arrangeInfo()
    {
        $this->info['list'] = $this->tenant_list;
    }

    private function arrangeTenantList()
    {
        $this->tenant_list = $this->tenantDB();
        foreach ($this->tenant_list as $key => $val) {
            $this->tenant_list[$key]['room'] = $this->tenantRoomDB($val['id']);
        }
    }

    private function tenantDB()
    {
        return M_TelTenant::where('tel_id','=',$this->tel_id)->get()->keyBy('id')->toArray();
    }

    private function tenantRoomDB($tenant_id)
    {
        return M_TelRoom::where('tenant_id','=',$tenant_id)->get(['name','notice','state'])->keyBy('id')->toArray();
    }





    


}
