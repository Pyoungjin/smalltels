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

    private $info = array(
            'ledger' => array(),
            'revenue' => 0,
            'expense' => 0,
            'amount' => 0,
            'search_month' => null,
            'pre_month' => null,
            'next_month' => null,
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
        $this->setMonth();

       
    }

    /**
     * 유저의 정보를 전달해줍니다.
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

    private function setLedger()
    {
        $this->info['search_month'] = (Request::input('date'))?Request::input('date'):date('Y-m');
 
        $this->info['ledger'] = M_TelAccount::where('tel_id','=',Request::route('tel_id'))
            ->where('date','like', $this->info['search_month']."%")
            ->get(['id' ,'tel_id', 'writer_user_id', 'date', 'action', 'price', 'content'])
            ->toArray();
    }

    private function setMonth()
    {
        $this->info['pre_month'] = date_add(
            date_create($this->info['search_month']),
            date_interval_create_from_date_string('last month')
            )->format('Y-m');

        // var_dump($this->info['last_month']);
        // exit();

        $this->info['next_month'] = date_add(
            date_create($this->info['search_month']),
            date_interval_create_from_date_string('next month')
            )->format('Y-m');

    }

    private function arrangeLedger()
    {
        foreach ($this->info['ledger'] as $val) {
            if($val['action'] == 'revenue')
            {
                $this->info['revenue'] += $val['price']; 
            }else if($val['action'] == 'expense')
            {
                $this->info['expense'] += $val['price']; 
            }
        }

        $this->info['amount'] = $this->info['revenue'] - $this->info['expense'];

    }
}
