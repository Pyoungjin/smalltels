@extends('layouts.office')

@section('title', '세입자')


@section('head')
	@parent

	
@stop

@section('content')
	<div style="border-bottom: 5px solid #aefe20; margin-bottom: 30px">
		<form action="/{{Request::path()}}/add-tenant" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			입주자 개인정보
			<div style="border-bottom: 2px solid #aaaaaa; margin: 15px; 100px">
				이름 : <input name='name' type='input'><br>
				phone : <input name='phone1' type='input'> - <input name='phone2' type='input'> - <input name='phone3' type='input'><br>
				생일 : <input name='birth_year' type='input'>년 <input name='birth_month' type='input'>월 /<input name='birth_day' type='input'>일<br>
				성별 : <select name='gender'>
					<option value="m">남자</option>
					<option value="w">여자</option>
				</select>
				직업 : <input name='job' type='input'><br>
				집 주소 : <input name='address' type='input'><br>
				기타사항 : <input name='notice' type='text'>
			</div>
			비상 연락망 1
			<div style="border-bottom: 2px solid #aaaaaa; margin: 15px; 100px">
				이름 : <input name='person1_name' type='input'><br>
				phone : <input name='person1_phone1' type='input'> - <input name='person1_phone2' type='input'> - <input name='person1_phone3' type='input'><br>
				관계 및 기타사항 : <input name='person1_notice' type='text'>
			</div>
			비상 연락망 2
			<div style="margin: 15px; 100px">
				이름 : <input name='person2_name' type='input'><br>
				phone : <input name='person2_phone1' type='input'> - <input name='person2_phone2' type='input'> - <input name='person2_phone3' type='input'><br>
				관계 및 기타사항 : <input name='person2_notice' type='text'>
			</div>
			<input type='submit' value="등록">

		</form>
	</div>

	{{var_dump(OTenant::info('list'))}}
@stop