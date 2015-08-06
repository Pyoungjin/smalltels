<?php

namespace App\Http\Controllers\Foundation;

use Validator;

use Auth;
use Request;

use Office;
use OTodo;

use TelRTodo;

use App\Model\M_TelRTodo;
use App\Model\M_TelRTodoHistory;


trait OfficeTodoTrait_Register
{   
    private $new_data = null;

    public function startForRegister()
    {
        $validator = $this->chkValidator();
        
        if ($validator->fails()) {
            $request = Request::instance();
            $this->throwValidationException(
                $request, $validator
            );
        }

        if(!$this->chkTypeIntervalMatching())
        {
            return redirect()->back()->with('message','type과 interval 불일치');
        }

        $this->setInitLastDate();

        if($tmp_result = TelRTodo::insert(
            Office::info('id')
            , Request::input('title')
            , Request::input('type')
            , Request::input('interval')
            , Request::input('last_date')
            )
        )
        {
            // $this->new_data = $tmp_result->toArray();
            $this->makeNewRTodoHistoryContent();
        }

        return $tmp_result;
        
    }

    private function chkValidator()
    {
        return Validator::make(Request::all(), [
                'interval' => 'numeric|max:31',
            ]);
    }

    private function chkTypeIntervalMatching()
    {
        if(($type = Request::input('type')) == 'monthly')
        {
            if(Request::input('interval') < date('t',$this->setLastDate()))
            {
                return true;
            }

        }
        else if( $type == 'weekly')
        {
            Request::input('interval') < 6;
            return true;
        }
        else if( $type == 'daily')
        {
            Request::input('interval') < 30;
            return true;
        }

        return false;

    }

    private function setInitLastDate()
    {   
        $year = date('Y');
        if(Request::input('month') < date('m')){
            $year++;
        }
        Request::merge(['year' => $year]);

        Request::merge(['last_date' => Request::input('year').'-'.Request::input('month').'-'.Request::input('date')]);
    }
    /**
     * 1. 기존에 만들어졌던 rtodo_history의 content를 불러온다.
     * 2. 새로 삽입된 결과의 데이터를 가지고온다. => $this->new_data
     * 3. 해당 결과를 가지고 rtodo_history에 삽입될 형태의 데이터를 만든다
     * 4. 새로 입력된 데이터와 rtodo아이디가 일치하는 자료가 있는지 확인한다.
     *     4-1 없다면 array_push 한다.
     *     4-2 있다면 두 데이터를 비교한다.
     *         4-2-1 당일 기준으로 앞쪽은 기존 것을/뒤쪽은 새로 업데이트된 것을 사용하여 가공한다.
     * 5. rtodo_history에 업데이트한다.
     * 6. ratodo의 바뀌 last_date를 업데이트한다.
     */
    private function makeNewRTodoHistoryContent()
    {
        //1.
        $this->setTargetDate();
        $this->setRTodoHistoryData();
        $this->setRTodoHistoryContent();
        //2.
        $this->setRTodoDataArr();
        // $this->rtodo_data_arr[0] = $this->new_data;
        //3.
        $this->makeRTodoHistoryNew();
        
        // var_dump($this->rtodo_history_new);
        // exit();
        
        //4
        $this->setNewRTodoHistoryNew();

        //5.
        $this->updateRTodoHistoryContent();

        //6.
        $this->updateRTodoLastDate();
        
    }

    private function setNewRTodoHistoryNew()
    {
        $tmp_result_arr = array();
        $tmp_all_arr = $this->rtodo_history_content + $this->rtodo_history_new;
        foreach ($tmp_all_arr as $key => $val) {
            $tmp_arr['rtodo_id'] = $val['rtodo_id'];
            $tmp_arr['do'] = $val['do'];
            $tmp_arr['date'] = $this->combineContent($val['rtodo_id']);

            $tmp_result_arr[$val['rtodo_id']] = $tmp_arr;
        }

        
        $this->rtodo_history_new = $tmp_result_arr;
        ksort($this->rtodo_history_new);
    }

    private function combineContent($chk_id)
    {
        $tmp_content = array_key_exists($chk_id , $this->rtodo_history_content);
        $tmp_new = array_key_exists($chk_id , $this->rtodo_history_new);
        if($tmp_content && !$tmp_new)
        {//content에는 있는데 new에는 없는것 => 사용자가 삭제했다.
            return  array_filter($this->rtodo_history_content[$chk_id]['date'],function($v){
                return (date_create($v)->format('Y-m-d') <= date_create()->format('Y-m-d'));
            });
        }else if(!$tmp_content && $tmp_new){
            //content에는 없는데 new에는 있는것. => 새로만들어졌다.
            return $this->rtodo_history_new[$chk_id]['date'];
        }else{//content와 new 둘다있는것
            if($this->rtodo_history_new[$chk_id]['date'] != $this->rtodo_history_content[$chk_id]['date'])
            {//둘다 있는데 내용이 다르다면 date가 바뀐것. 
                return $this->chkNewContent($chk_id);
            }else{
                return $this->rtodo_history_new[$chk_id]['date'];
            }
        }


    }

    private function chkNewContent($chk_id)
    {
        $tmp_arr = array_filter($this->rtodo_history_content[$chk_id]['date'],function($val){
            return (date_create($val)->format('Y-m-d') <= date_create()->format('Y-m-d'));
        });
        $tmp_arr_new = array_filter($this->rtodo_history_new[$chk_id]['date'],function($val){
            return (date_create($val)->format('Y-m-d') >= date_create()->format('Y-m-d'));
        });
        return $tmp_arr + $tmp_arr_new;

    }

    

    private function updateRTodoHistoryContent()
    {
        M_TelRTodoHistory::find($this->rtodo_history_data['id'])->update([
            'content' => json_encode($this->rtodo_history_new)
            ]);   
    }


}
?>