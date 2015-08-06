@extends('layouts.office')

@section('title')
	To do
@stop

@section('head')
	@parent

	
@stop

@section('content')
	<div>
		<form action='/{{Request::path()}}/r-todo' method='post'>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			할일 이름 <input name='title' placeholder='ex) 화장실 청소'><br>
			
			시작일 :<br>
			
			<select name='target_m'>
			@for($i = 1 ; $i < 13 ; $i++ )
				<option value='{{$i}}' {{($i == date("m"))? "selected": "" }}>{{$i}}</option>
			@endfor
			</select> 월 
			 
			<select name='target_d'>
			@for($i = 1 ; $i < 32 ; $i++ )
				<option value='{{$i}}' {{($i == date("d"))? "selected": "" }}>{{$i}}</option>
			@endfor
			</select> 부터 
			주기 : 
			<select name='type'>
				<option value="period">정기적으로</option>
				<option value="monthly">매달마다</option>
				<option value="weekly">매주마다</option>
			</select>
			<select name='interval'>
			@for($i = 1 ; $i < 32 ; $i++ )
				<option value='{{$i}}'>{{$i}}</option>
			@endfor
			</select>일(마다) 시행<br>
			<input type="submit" value="입력">


		</form>
	</div>
	<div>
		<h1>Todo List</h1>
		{{var_dump(OTodo::info())}}
		
	</div>
	@include('parts.month_component')
@stop