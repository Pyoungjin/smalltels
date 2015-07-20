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
				<option value="deposite">입금</option>
				<option value="withdraw">출금</option>
			</select><br>
			금액:<input type="text" name="price" placeholder="100000">원<br>
			내용:<input type="text" name="content" placeholder="ex) 101호 세입자 방세 납입"><br>
			<input type="submit" value="기록하기">
	</div>
@stop