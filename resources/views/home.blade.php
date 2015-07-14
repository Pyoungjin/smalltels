@extends('layouts.home')

@section('title', 'Page Title')
	'home'
@stop

@section('content')

	@if(Auth::check())
		<a href="auth/logout">로그아웃</a>
	@endif
	{{-- 고시원 등록 --}}
	<a href="goRegister">새 고시원 등록</a>
	{{-- 총무 신청 --}}
	<a href="applocation">총무 신청</a>
	{{-- 사용설명서 --}}
	<a href="manual">Smalltels 사용법</a>
	{{-- 개인정보관리 --}}
	<a href="admin">개인정보 관리</a>
	{{-- 각 고시원별 이동 탭 --}}
	<a href="">@각고시원별 이동</a>
	@if($tmp_message = Session::get('message'))
		"{{$tmp_message}}"
	@endif
@stop