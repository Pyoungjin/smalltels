<?php

namespace App\Http\controllers\Foundation;

use User;
use Request;
use STDate;

use App\Model\M_TelRTodo;
use App\Model\M_TelRTodoSchedule;
use App\Model\M_TelRTodoPerform;

use Office;

// use App\Http\Controllers\Foundation\OfficeTodoTrait_Register;

/**
 * 유저가 요청한 office todo의 정보를 가져온다.
 */
class OfficeTodoHandler
{
    // use OfficeTodoTrait_Register;

    private $start = false;

    private $tel_id = null;
    private $target_month = null;
    private $current_month = null;
    private $standard_date = null;
    /**
     * $rtodo_list
     * $rtodo_list :[
     *     @'rtodoid' : [
     *              'id': $id, 'tel_id' : $tel_id, 'title' : $title, 'type' : $type, 'interval' : $interval,
     *              'schedule' : [@(date_type:'d')$date],
     *              'perform'  : [@perform_id: (date_type:'d')$perform_date],
     *              'perform_list : @['id' : $id, 'rtodo_id': $rtodo_id,
     *                              'date' :$perform_date ,'state':$state,'user_id':$user_id]
     *     ]
     * ]
     */
    private $rtodo_list = [];
    private $perform_list = [];

    private $info = [
        'id'            => null,
        'target_month'  => null,
        't'             => null,
        'rtodo_list'    => [],
        'today_schedule'=> [],
        ];

   

    public function __construct()
    {
        $this->tel_id = Office::info('id');
        $this->current_month = date('Y-m');

    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        $this->start = true;

        $this->setTargetMonth(Request::input('search_month'));
        $this->setTargetMonthT($this->info['target_month']);
        $this->setRTodoList($this->tel_id);

        $this->setRTodoSchedule();
        $this->setRTodoPerform();

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

    public function rtodo($rtodo_id)
    {   
        if(!$this->start)
        {
            $this->start();
        }

        return $this->info['rtodo_list'][$rtodo_id];
    }

    private function arrangeInfo()
    {
        $this->info['target_month']     = $this->target_month;
        $this->info['rtodo_list']       = $this->rtodo_list;
        $this->info['today_schedule']   = $this->todaySchedule();
    }

    private function setTargetMonth($target_month = null)
    {
        $this->target_month = ($target_month)?$target_month:date('Y-m');
    }

    private function setTargetMonthT($target_month)
    {
        $this->info['t'] = date_create($target_month)->format('t');
    }

    private function setRTodoList($tel_id)
    {
        $rtodo_list_arr = M_TelRTodo::where('tel_id','=',$tel_id) -> get([
            'id', 'title', 'type', 'interval', 'standard_date'
            ]) -> toArray();

        foreach ($rtodo_list_arr as $val) {
            $this->rtodo_list[$val['id']] = $val;
        }
    }

    private function setRTodoSchedule()
    {
        if(!$this->target_month)
        {
            $this->setTargetMonth();
        }
        foreach ($this->rtodo_list as $val) {
            $this->rtodo_list[$val['id']]['schedule'] = $this->setSchedule($val['id']);
        }
    }

    private function setSchedule($rtodo_id)
    {
        if(!$schedule_json = M_TelRTodoSchedule::where('rtodo_id','=',$rtodo_id)
            ->where('target_month','like',$this->target_month.'%')->get(['schedule'])->toArray())
        {
            if($this->target_month == $this->current_month)
            {
                $schedule_json = $this->newSchedule($rtodo_id, $this->target_month);
            }else{
                $schedule_json = "{}";
            }
        }else{
            $schedule_json = $schedule_json[0]["schedule"];

        }
        // var_dump($schedule_json );
        // exit();
        return json_decode($schedule_json,true);
    }

    // private function 

    private function newSchedule($rtodo_id, $target_month)
    {
        $this->standard_date = null;
        $create_info_arr = $this->createSchedule($rtodo_id, $target_month)->toArray();
        $new_rtodo = $this->updateRtodo($rtodo_id);

        return $create_info_arr['schedule'];
    }

    private function createSchedule($rtodo_id, $target_month)
    {

        return M_TelRTodoSchedule::create([
            'rtodo_id'      => $rtodo_id,
            // 'target_month'  => "2015-08-01",
            'target_month'  => $target_month.'-01',
            'schedule'      => $this->initScheduleJson($rtodo_id),
            ]);
    }

    private function initScheduleJson($rtodo_id)
    {
        return json_encode($this->initScheduleArr($rtodo_id));
    }

    private function initScheduleArr($rtodo_id)
    {
        if(!$this->rtodo_list)
        {
            $this->setRTodoList($this->tel_id);
        }

        $rtodo = $this->rtodo_list[$rtodo_id];
        $standard_date = $rtodo['standard_date'];
        $interval  = $rtodo['interval'];
        $type      = $rtodo['type'];

        if($type == 'period')
        {
            return $this->initPeriodScheduleArr($standard_date, $interval);
        }elseif($type == 'weekly'){
            return $this->initWeeklyScheduleArr($interval);
        }elseif($type == 'monthly'){
            return $this->initMonthlyScheduleArr($interval);
        }
    }

    private function initPeriodScheduleArr($standard_date, $interval)
    {
        $result_arr = [];
        $first_date = date_create($standard_date);

        $t = date('t');
        $today = date('d');

        while($first_date->format('Y-m') != date('Y-m'))
        {

            $first_date = date_add( $first_date, date_interval_create_from_date_string($interval.' days'));
            // var_dump($first_date->format('Y-m'));
        }
        // exit();

        $target_date = (int)$first_date->format('d');

        while($target_date <= $t)
        {
            if($target_date >= $today)
            {
                array_push($result_arr, $target_date);
            }
            $target_date += $interval;
        }

        $this->standard_date = date('Y-m-').end($result_arr);

        return $result_arr;
    }

    private function initWeeklyScheduleArr($interval)
    {
        $result_arr = [];

        $t = date('t');
        $today = date('d');

        $target_date = 0;

        for ($i=1; $i < 8 ; $i++) { 
            if(date_create(date('Y-m').'-'.$i)->format('w') == $interval)
            {
                $target_date = $i;
                $i = 8;
            }
        }

        while($target_date <= $t)
        {
            if($target_date >= $today )
            {
               array_push($result_arr, $target_date);
            }
            $target_date += 7;
        }

        $this->standard_date = date('Y-m-').end($result_arr);

        return $result_arr;
    }

    private function initMonthlyScheduleArr($interval)
    {
        $t = date('t');

        $this->standard_date = date('Y-m-d');

        if($interval == 0)
        {
            return [(int)$t];
        }elseif($interval > $t){
            return [];
        }elseif($interval <= $t){
            return [(int)$interval];
        }
    }

    private function updateRtodo($rtodo_id)
    {
        if(!M_TelRTodo::find($rtodo_id)->update([
            'standard_date' => $this->standard_date
            ]))
        {
            $this->rtodo_list[$rtodo_id] = M_TelRTodo::find($rtodo_id)->toArray();
        }
    }

    private function todaySchedule()
    {
        $tmp_arr=[];
        $today = date('j');
        foreach ($this->rtodo_list as $val) {
            if(in_array($today, $val['schedule']))
            {
                array_push($tmp_arr,$val['id']);
            }
        }

        return $tmp_arr;
    }

    private function setRTodoPerform()
    {
        $this->setPerformList();
        // $this->setPerform();
    }

    private function setPerformList()
    {
         foreach ($this->rtodo_list as $val) {
            $this->rtodo_list[$val['id']]['perform_list'] = $this->setPerformInfo($val['id']);
            $this->setPerform($this->rtodo_list[$val['id']]);
         }
    }

    private function setPerformInfo($rtodo_id)
    {
        return M_TelRTodoPerform::where('rtodo_id','=',$rtodo_id)
        ->where('date','like',$this->info['target_month'].'%')->get(['id','rtodo_id','date','state','user_id'])->toArray();
    }

    private function setPerform(&$rtodo)
    {
        $rtodo['perform'] = array_column($rtodo['perform_list'],'date','id');
        array_walk($rtodo['perform'], function(&$item)
        {
            $item = date_create($item)->format('d');
        });
    }

}
