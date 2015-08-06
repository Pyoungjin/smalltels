<?php

namespace App\Http\controllers\Foundation;

use User;
use Request;
// use TelsEvent;
// use TelsList;
// use TelStaffs;

use App\Model\M_TelRTodo;
use App\Model\M_TelRTodoHistory;

use Office;

use App\Http\Controllers\Foundation\OfficeTodoTrait_Register;

/**
 * 유저가 요청한 office todo의 정보를 가져온다.
 */
class OfficeTodoHandler
{
    use OfficeTodoTrait_Register;

    private $start = false;
    private $target_month = null;
    private $rtodo_history_data = array();
    private $rtodo_history_content = array();

    private $rtodo_data_arr = array();//tel_rtodo_history테이블에 데이터 입력시 필요
    private $rtodo_history_new = array();//tel_rtodo_history테이블에 데이터 입력시 필요

    private $info = array(
        'id'        => null,
        'year'      => null,
        'month'     => null,
        'content'    => array(),
        'list_count'=> null,
        );

   

    public function __construct()
    {

    }

    /**
     * 객체 사용을 시작할때 호출합니다. 객체의 기본 설정을 세팅합니다.
     * @return void 
     */
    public function start()
    {
        if($this->start){
            return $this;
        }
        $this->start = true;
        $this->setRtodoHistory();

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

    public function updateComplate()
    {
        // Request::input('history_id');
        if(!$this->start)
        {
            $this->start();
        }
        $rtodo_id = Request::input('rtodo_id');

        $this->rtodo_history_content[$rtodo_id]['do'][date('Y-m-d')]['user_id'] = User::info('id');
        $this->rtodo_history_content[$rtodo_id]['do'][date('Y-m-d')]['date'] = date('Y-m-d');

        return M_TelRTodoHistory::find($this->info['id'])->update([
            'content' => json_encode($this->rtodo_history_content)
            ]);
    }

    /**
     * 1. history에 해당 tel_id와 target_month에 조건이 충족하는 데이터가 있는지 확인한다.
     * 2. 없다면 생성한다.
     *     2-1 요청한 월이 현제인지 확인 후 상이하다면 데이터 없음을 반송한다.
     *     2-2 상이하지 않다면 데이터를 생성한다.
     * 3. 데이터를 불러온다.
     * 4. 불러온 데이터를 가공한다.
     */
    private function setRtodoHistory()
    {
        $this->setTargetDate();
        $this->setRTodoHistoryData();
        $this->setRTodoHistoryContent();
        $this->setInfo();
        $this->setListCount();

        // var_dump($this->rtodo_history_content);
        // var_dump($this->info);
        // exit();
        
    }

    private function setTargetDate()
    {
        if(!Request::input('target_month'))
        {
            Request::merge(['target_month' => date('Y-m')]);
        }

        $this->target_month = date_create(Request::input('target_month'))->format('Y-m');
    }

    private function setRTodoHistoryData()
    {
        if(!count($history_data = $this->getRtodoHistory()))
        {  
            $target_month = date_create($this->target_month)->format('Y-m');
            $current_month = date_create()->format('Y-m');

            if($target_month == $current_month)//요청한 달과 지금 현제이면..
            {
                //데이터 생성
                $history_data = $this->insertRTodoHistory();

            }
            else//요청한 달이 현제가 아니면..
            {
                //데이터 없음 내보내기
                var_dump('요청한 달에 데이터 없음');
                exit();
            }
        }else{
            $history_data = $history_data[0];
        }

        $this->rtodo_history_data = $history_data;

        // var_dump($this->rtodo_history_data);
    }

    private function getRtodoHistory()
    {
        return M_TelRTodoHistory::where('tel_id','=',Office::info('id'))
            ->where('target_month','like',$this->target_month.'%')->get()->toArray();
    }

    /**
     * 1. rtodo테이블에서 작성할 hitory와 관련된 데이터를 불러온다.
     * 2. @ 각 목록 마다 계산한다.
     *     2-1 type을 구분한다.
     *         2-1-1 monthy일때: 
     *             2-1-1-1 해당 날을 저장한다.
     *             2-1-1-2 날짜가 벗어놨다면 직전 날짜를 rtodo::last_date에 업데이트한다. 
     *         2-1-2 weekly일떄: 
     *             2-1-2-1 last_date를 시작으로 7일씩 더해간다.
     *             2-1-2-2 해당 날짜가 당월을 벗어났는지 확인한다.
     *             2-1-2-3 
     *                 2-1-2-3-1 해당날짜가 벗어나지 않았다면 날짜를 입력한다.
     *                 2-1-2-3-2 날짜가 벗어놨다면 직전 날짜를 rtodo::last_date에 업데이트한다. 
     *         2-1-3 daily일떄: 
     *             2-1-3-1 last_date를 interval만큼 더해간다.
     *             2-1-3-2 해당 날짜가 당월을 벗어났는지 확인한다.
     *             2-1-3-3 
     *                 2-1-3-3-1 해당날짜가 벗어나지 않았다면 날짜를 입력한다.
     *                 2-1-3-3-2 날짜가 벗어놨다면 직전 날짜를 rtodo::last_date에 업데이트한다.
     *      2-2 $rtodo_history_new에 각 결과를 push한다.
     *  3. rtodo_history_new를 json으로 인코딩한다.
     *  4. tel_rtodo_history테이블에 인설트한다.
     */
    private function insertRTodoHistory()
    {
        $this->setRTodoDataArr();
        $this->makeRTodoHistoryNew();
        // var_dump($this->rtodo_history_new);
        // exit();
        $this->updateRTodoLastDate();
        ksort($this->rtodo_history_new);
        return M_TelRTodoHistory::create([
            'tel_id'    => Office::info('id'),
            'target_month'  => date('Y-m-d'),
            'content'   => json_encode($this->rtodo_history_new)//이거 고쳐야됨.
        ])->toArray();   
    }

    private function setRTodoDataArr()
    {
        $this->rtodo_data_arr = M_TelRTodo::where('tel_id','=',Office::info('id'))
            ->get()->toArray();

        // var_dump($this->rtodo_data_arr);
    }

    private function makeRTodoHistoryNew()
    {
        foreach ($this->rtodo_data_arr as $val) {
            $this->rtodo_history_new[$val['id']] = $this->setContent($val);
        }


    }

    private function updateRTodoLastDate()
    {   
        foreach ($this->rtodo_history_new as $key => $val) {

            M_TelRTodo::find($val['rtodo_id'])->update([
                'last_date' => end($val['date'])
                ]);
        }
        
    }

    private function setContent(array $data)
    {
        $date_arr = array();

        if($data['type'] == 'monthly')
        {
            $date_arr = $this->makeDateArrForMonth($data['last_date'],$data['interval']);
        }
        else if($data['type'] == 'weekly')
        {
            $date_arr = $this->makeDateArr($data['last_date'], 7);

        }
        else if($data['type'] == 'daily')
        {
            $date_arr = $this->makeDateArr($data['last_date'], $data['interval']);
        }

        return array(
            'rtodo_id' => $data['id'],
            'do' => array(),
            'date' => $date_arr,
            );
    }

    private function makeDateArr($last_date, $interval){
        $tmp_arr = array();
        $interval = date_interval_create_from_date_string($interval." days");

        $current_month = date_create()->format('Y-m');
        
        $date = date_create($last_date);

        $i = true;
        while($i){
            $date_month = $date->format('Y-m');
             
            if($current_month == $date_month)
            {
                array_push($tmp_arr,$date->format('Y-m-d'));
                date_add($date,$interval);
            }
            else if($current_month > $date_month)
            {
                date_add($date,$interval);
            }
            else if($current_month < $date_month)
            {
                $i = false;
            }

             
        }

        
        return $tmp_arr;

    }

    private function makeDateArrForMonth($last_date, $interval)
    {
        if($interval)
        {
            $tmp_arr = array(date('Y-m').'-'.$interval);
        }
        else
        {    
            $tmp_arr = array(date('Y-m').'-'.date('t'));
        }
        
        return $tmp_arr;

    }

    private function setRTodoHistoryContent()
    {
        $this->rtodo_history_content = json_decode($this->rtodo_history_data['content'],true);
    }

    private function setInfo()
    {
        $this->info['id']       = $this->rtodo_history_data['id'];
        $this->info['year']     = date_create($this->target_month)->format('Y');
        $this->info['month']    = date_create($this->target_month)->format('m');
        $this->info['content']  = $this->setInfoContent();
    }

    private function setInfoContent()
    {
        $tmp_arr = array();
        if(is_array($this->rtodo_history_content))
        {
            $tmp_arr = $this->rtodo_history_content;
        }

        foreach ($tmp_arr as $key => $val) {
            $tmp_arr[$key]['do_date'] = array();
            foreach($val['do'] as $do_list){
                array_push($tmp_arr[$key]['do_date'], $do_list['date']);
            }
        }

        return $tmp_arr;
    }

    private function setListCount()
    {
        $this->info['list_info'] = count($this->rtodo_history_content);
    }


    


}
