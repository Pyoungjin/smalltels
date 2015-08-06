<?php

namespace App\Http\controllers\Foundation;

use Request;



class SmallTelDateHandler
{
    private $start = false;

    private $init = [

    ];
    private $info = [
        'search_month' => null,
        'pre_month' => null,
        'next_month' => null,
        'search_available' => false,

        'target_month' => null,
    ];


    public function __construct()
    {
        


    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        $this->start = true;
        $this->setSearchMonth();
        $this->setPreMonth();
        $this->setNextMonth();
        $this->setSearchAvailable();
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

    private function setSearchMonth()
    {
        $this->info['search_month'] = ($tmp = Request::input('search_month'))?$tmp:date('Y-m');
    }

    private function setSearchAvailable()
    {
        if($this->info['search_month'] <= date('Y-m') || $this->info['search_month'] >= '2015-06')
        {
            $this->info['search_available'] = true ;
        }
    }

    private function setPreMonth()
    {   
        if($this->info['search_month'] && $this->info['search_month'] > '2015-06')
        {
                $this->info['pre_month'] = date_add(
                date_create($this->info['search_month']),
                date_interval_create_from_date_string('last month')
                )->format('Y-m');
        }
    }

    private function setNextMonth()
    {   
        if($this->info['search_month'] && $this->info['search_month'] < date('Y-m'))
        {
                $this->info['next_month'] = date_add(
                date_create($this->info['search_month']),
                date_interval_create_from_date_string('next month')
                )->format('Y-m');
        }
    }

}
