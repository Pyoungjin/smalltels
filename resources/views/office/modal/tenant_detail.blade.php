@if(!count($tenant = OTenant::tenant(Request::input('tenant_id'))))
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4>에러</h4>
  귀하의 회원정보를 불러오는 중 알 수 없는 오류가 발생하였거나 비 정상적인 접속입니다. 
</div>
@endif

<div style='padding: 5px 0px; border-bottom: 2px solid #e5e5e5'>
<h4>입주자 정보</h4>
	<table class='table table-bordered'>
		<tr>
			<td>이름</td><td>{{$tenant['name']}}</td>
			<td>성별</td><td>{{$tenant['gender']}}</td>
			
		</tr>
		<tr>
			<td>직업</td><td>{{$tenant['job']}}</td>
			<td>생일</td><td>{{$tenant['birth_year'].'년 '.$tenant['birth_month'].'월 '.$tenant['birth_day'].'일'}}</td>
		</tr>
		<tr>
			<td>연락처</td><td colspan="3">{{$tenant['phone1'].'-'.$tenant['phone2'].'-'.$tenant['phone3']}}</td>
		</tr>
		<tr>
			<td>주소</td><td colspan="3">{{$tenant['address']}}</td>
		</tr>
	</table>





	<div style='witdh:503px;' >
	  <div style="width:515px; padding:6px;border:1px solid #ccc; border-radius: 4px 4px 0px 0px; background-color: #eee;">
	    특이사항 
	  </div>
	  <div style="width:515px; padding:6px; min-height:50px; border-top:0px; border:1px solid #ccc; border-radius: 0px 0px 4px 4px; " >{{$tenant['notice']}}</div>
	</div>
</div>
{{--  --}}
<div style='padding: 5px 0px; border-bottom: 2px solid #e5e5e5'>
<table class='table table-bordered'>
	<tr>
		<td colspan="4"><h5>비상 연락망 1</h5></td>

	</tr>
	<tr>
		<td>이름</td><td>{{$tenant['person1_name']}}</td>
		<td>연락처</td><td>{{$tenant['person1_phone1'].'-'.$tenant['person1_phone2'].'-'.$tenant['person1_phone3']}}</td>
	</tr>
	<tr>
		<td>기타</td><td colspan="3">{{$tenant['person1_notice']}}</td>
	</tr>
</table>
<table class='table table-bordered'>
	<tr>
		<td colspan="4"><h5>비상 연락망 2</h5></td>

	</tr>
	<tr>
		<td>이름</td><td>{{$tenant['person2_name']}}</td>
		<td>연락처</td><td>{{$tenant['person2_phone1'].'-'.$tenant['person2_phone2'].'-'.$tenant['person2_phone3']}}</td>
	</tr>
	<tr>
		<td>기타</td><td colspan="3">{{$tenant['person2_notice']}}</td>
	</tr>
</table>

</div>