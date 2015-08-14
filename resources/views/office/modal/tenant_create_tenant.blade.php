<!-- Modal -->
<div id="createTenant" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="/{{Request::path()}}/add-tenant" method="post">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">세입자 등록</h3>
    </div>
    <div class="modal-body">
        
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div style='padding: 5px 0px; border-bottom: 2px solid #e5e5e5'>
            <h4>입주자 정보</h4>

            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>이 름</span>
              <input class="span2" name='name' type="text" placeholder="홍길동">
            </div>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>성별</span>
              <select name='gender' class='span1'>
                <option value="m">남자</option>
                <option value="w">여자</option>
              </select>
            </div>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>직업</span>
              <input name='job' type='text' class='span2'>
            </div><br>
            <div class="input-prepend input-append">
              <span class="add-on" style='width:37px;'>연락처</span>
              <select name='phone1' type='text' style='width:90px;'>
              @include('parts.ui_phone1')
              </select>
              <span class="add-on">-</span>
              <input name='phone2' type='text' style='width:65px;'>
              <span class="add-on">-</span>
              <input name='phone3' type='text' style='width:65px; border-radius: 0px 4px 4px 0px;'>
            </div><br>
            <div class="input-prepend input-append">
              <span class="add-on" style='width:37px;'>생일</span>
              <select name='birth_year' class='span2' style='width:66px;'>
              @for($i=(date('Y')-15);$i>1940;$i--)
                <option value="{{$i}}">{{$i}}</option>
              @endfor
              </select>
              <span class="add-on">년</span>
              <select name='birth_month' class='span1'>
              @for ($i=1; $i < 13; $i++)
                <option value="{{$i}}">{{$i}}</option>
              @endfor
              </select>
              <span class="add-on">월</span>
              <select name='birth_day' class='span1'>
              @for ($i=1; $i < 32; $i++)
                <option value="{{$i}}">{{$i}}</option>
              @endfor
              </select>
              <span class="add-on">일</span>
            </div><br>
            
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>주소</span>
              <input name='address' type='text' class='span4'>
            </div>
            <div style='witdh:400px;' >
              <div style="width:503px; padding:6px;border:1px solid #ccc; border-radius: 4px 4px 0px 0px; background-color: #eee;">
                특이사항 
              </div>
              <textarea name='notice' type='text' row='3' style="width:503px; height:50px;border-top:0px; border-radius: 0px 0px 4px 4px; " placeholder='다음주 토요일 입실예정'></textarea>
            </div>
          </div>
            {{--  --}}
          <div style='padding: 5px 0px; border-bottom: 2px solid #e5e5e5'>
            <h5>비상 연락망 1</h5>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>이 름</span>
              <input class="span2" name='person1_name' type="text" placeholder="홍판서">
            </div>
            <div class="input-prepend input-append">
              <span class="add-on" style='width:37px;'>연락처</span>
              <select name='person1_phone1' class='span2' type='text'>
              @include('parts.ui_phone1')
              </select>
              <span class="add-on">-</span>
              <input name='person1_phone2' class='span2' type='text'>
              <span class="add-on">-</span>
              <input name='person1_phone3' class='span2' type='text' style='border-radius: 0px 4px 4px 0px;'>
            </div><br>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>기 타</span>
              <input name='person1_notice' type='text' placeholder='입주자의 아버지'>
            </div>
          </div>
          <div style='padding: 5px 0px; '>
            <h5>비상 연락망 2</h5>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>이 름</span>
              <input class="span2" name='person2_name' type="text" placeholder="김철수">
            </div>
            <div class="input-prepend input-append">
              <span class="add-on" style='width:37px;'>연락처</span>
              <select name='person2_phone1' class='span2' type='text'>
              @include('parts.ui_phone1')
              </select>
              <span class="add-on">-</span>
              <input name='person2_phone2' class='span2' type='text'>
              <span class="add-on">-</span>
              <input name='person2_phone3' class='span2' type='text' style='border-radius: 0px 4px 4px 0px;'>
            </div><br>
            <div class="input-prepend ">
              <span class="add-on " style='width:37px;'>기 타</span>
              <input name='person2_notice' type='text' placeholder='입주자의 친구'>
            </div>
          </div>

          

          
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">취</button>
      <input class="btn btn-primary" type='submit' value="등록">
    </div>
  </form>
</div>