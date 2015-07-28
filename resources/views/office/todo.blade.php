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
	<div>
		<h1>Todo List</h1>
		<span>{{date('Y 년 m 월')}}</span>
		@if(count($OTodo = OTodo::info('content')))
		<table>
			<tr>
				<td>todo_id</td>

				@for($i = 1  ; $i <= date('t');$i++)
					<td>
						{{ $i.'일'}}
					</td>
				@endfor
			</tr>
			{{-- {{var_dump($Otodo)}} --}}
			@foreach ($OTodo as $val)
				<tr>
					<td>{{$val['rtodo_id']}}</td>
					@for($i = 1 ; $i <= date('t');$i++)

						@if(in_array(date('Y-m-').$i,$val['date']))
							@if(array_key_exists(date('Y-m-').$i,$val['do']))
								<td>{{$val['do'][date('Y-m-').$i]['user_id'].' 완'}}</td>
							@else
								<td>
									@if(date('Y-m-').$i == date('Y-m-d'))
									<form action="/{{Request::path()}}/complate" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										{{-- <input type="hidden" name="history_id" value="{{ OTodo::info('id') }}"> --}}
										<input type="hidden" name="rtodo_id" value="{{ $val['rtodo_id'] }}">
										<input type="submit" value="확인">
									</form>
									@endif
								</td>
							@endif
						@else 
							<td>x</td>
						@endif
					@endfor
				</tr>
			@endforeach
		</table>
		@else
			등록된 할일이 없습니다.
		@endif
	</div>
@stop