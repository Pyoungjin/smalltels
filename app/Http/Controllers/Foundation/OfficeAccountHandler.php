<?php

namespace App\Http\controllers\Foundation;

use Auth;
use Request;

use App\Model\M_TelAccount;


// use App\Model\M_TelsList;
// use App\Model\M_TelMember;
// use Illuminate\Http\Request;


class OfficeAccountHandler
{
    private $start = false;
    // private $requsted_user_id = null;
    private $permission = null;

    private $office_account_info = array(
            'ledger' => array(),
            'revenue' => 0,
            'expense' => 0,
            'amount' => 0,
        );


    /**
     * 1. 로그인 여부를 판단한다. => 로그인이 안되있으면 로그인 화면으로 보낸다.
     * 2. 유저가 속한 오피스의 리스트를 가지고 온다.
     */
    
    /**
     * 단위 유저의 정보를 담은 객체를 생성하는 클래스
     */
    public function __construct()
    {
        


    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        $this->setLedger();
        $this->arrangeLedger();
        // var_dump($this->office_account_info);
        // exit();
    }

    /**
     * 유저의 정보를 전달해줍니다.
     * @param  string $key 가져오고 싶은 정보의 키값을 전달합니다. 키값이 없으면 전체 배열을 전달합니다. 
     * @return mixed       요청한 정보를 전달합니다.
     */
    public function info($key = null)
    {   
        if($key) {
            return $this->office_account_info[$key];
        }

        return $this->office_account_info;
    }

    private function setLedger()
    {
        $search_month = (Request::input('date'))?Request::input('date').'%':date("Y-m").'%';
        // var_dump($search_month);
        // exit();
        $this->office_account_info['ledger'] = M_TelAccount::where('tel_id','=',Request::route('tel_id'))
            ->where('date','like', $search_month)
            ->get(['id' ,'tel_id', 'writer_user_id', 'date', 'action', 'price', 'content'])
            ->toArray();
    }

    private function arrangeLedger()
    {
        foreach ($this->office_account_info['ledger'] as $val) {
            if($val['action'] == 'revenue')
            {
                $this->office_account_info['revenue'] += $val['price']; 
            }else if($val['action'] == 'expense')
            {
                $this->office_account_info['expense'] += $val['price']; 
            }
        }

        $this->office_account_info['amount'] = $this->office_account_info['revenue'] - $this->office_account_info['expense'];

    }
}
