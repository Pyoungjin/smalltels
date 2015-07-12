@extends('layouts.master')

@section('title', 'Page Title')
	'home'
@stop

@section('content')
	@if(Auth::check())
		<a href="auth/logout">로그아웃</a>
	@endif
@stop