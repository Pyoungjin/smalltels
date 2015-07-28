@extends('layouts.office')

@section('title', 'Room')


@section('head')
	@parent

	
@stop

@section('content')
	<div>{{date('Y년 m월')}}</div>
	<div>
		<form action="/{{Request::Path()}}/add-room" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="text" name="order" value="1">개
			<input type="submit" value="만들기">
		</form>
	</div>
	@if(ORoom::count('list'))
	<table>
		<tr>
			<td>방호수(이름)</td>
			<td>입주자</td>
			<td>상태</td>
			<td>특이사항</td>
			<td>수정</td>
		</tr>
		@foreach (($oroom = ORoom::info('list')) as $key => $val)
		<tr>
			<form action="/{{Request::Path()}}/add-room-info" method="post">
				<td>
					<input type='text' value="{{$val['name']}}" placeholder="이름(또는 호수)를 입력해주세요.">
				</td>
				<td>
					<input type='text' value="{{$val['tenant']}}" placeholder="입주자">
				</td>
				<td>
					<input type='text' value="{{$val['explain']}}" placeholder="특이사항">
				</td>
				<td>
					<select name='state'>
						<option value="fill" {{($val['state'] == 'fill')?'selected':''}}>입실완료</option>
						<option value="cleaning" {{($val['state'] == 'cleaning')?'selected':''}}>청소요망</option>
						<option value="empty" {{($val['state'] == 'empty')?'selected':''}}>비어져있음</option>
						<option value="reservation" {{($val['state'] == 'reservation')?'selected':''}}>예약됨</option>
					</select>
				</td>
				<td>
					<input type='submit' value='수정'>
				</td>
			</form>
		</tr>	
		@endforeach
	</table>
	@endif
@stop