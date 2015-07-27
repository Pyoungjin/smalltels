@extends('layouts.office')

@section('title', 'Todo')


@section('head')
	@parent

	
@stop

@section('content')
	<div>
		<form action='/{{Request::path()}}/r-todo' method='post'>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			할일 이름 <input name='title' placeholder='ex) 화장실 청소'><br>
			
			시작일 :<br>
			
			<select name='month'>
			@for($i = 1 ; $i < 13 ; $i++ )
				<option value='{{$i}}' {{($i == date("m"))? "selected": "" }}>{{$i}}</option>
			@endfor
			</select> 월 
			 
			<select name='date'>
			@for($i = 1 ; $i < 32 ; $i++ )
				<option value='{{$i}}' {{($i == date("d"))? "selected": "" }}>{{$i}}</option>
			@endfor
			</select> 부터 
			주기 : 
			<select name='type'>
				<option value="daily">(직접 입력)</option>
				<option value="monthly">매달</option>
				<option value="weekly">매주</option>
			</select>
			<select name='interval'>
			@for($i = 1 ; $i < 32 ; $i++ )
				<option value='{{$i}}'>{{$i}}</option>
			@endfor
			</select>일(마다) 시행<br>
			<input type="submit" value="입력">


		</form>
	</div>
@stop