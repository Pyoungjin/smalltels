@extends('layouts.office')

@section('title', 'Office Account')


@section('head')
	@parent

	
@stop

@section('content')
	<div>
		<form method="post" action="/{{Request::Path()}}/recoder">
		{{-- <form method="post" action="recoder"> --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<select name='action'>
				<option value="revenue">수입</option>
				<option value="expense">지출</option>
			</select><br>
			금액:<input type="text" name="price" placeholder="100000">원<br>
			내용:<input type="text" name="content" placeholder="ex) 101호 세입자 방세 납입"><br>
			<input type="submit" value="기록하기">
	</div>

	@if(count($ledger = OAccount::info('ledger')))
	{{-- {{var_dump($ledger)}} --}}
	<div>
		<span>수입:{{OAccount::info('revenue')}}</span>
		<span>지출:{{OAccount::info('expense')}}</span>
		<span>합계:{{OAccount::info('amount')}}</span>
	</div>
	<div>
		<table>
			<tr>
				<td>날짜</td>
				<td>수입</td>
				<td>지출</td>
				<td>내용</td>
				<td>처리</td>
			</tr>
		@foreach ($ledger as $val) 
			<tr>
				<td>{{$val['date']}}</td>
				@if($val['action'] == 'revenue')
				<td>{{$val['price']}}</td>
				<td></td>
				@elseif($val['action'] == 'expense')
				<td></td>
				<td>{{$val['price']}}</td>
				@endif
				<td>{{$val['content']}}</td>
				<td>{{$val['user_id']}}</td>
			</tr>
		@endforeach
		</table>
	</div>
	@endif
@stop