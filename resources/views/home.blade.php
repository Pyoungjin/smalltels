@extends('layouts.home')

@section('title', 'Page Title')


@section('head')
	@parent

	@if(($list = TelsList::telsList()) != null)
		@foreach ( $list as $val)
		{{-- {{var_dump($val)}} --}}
			<a href='/office/{{$val["id"]}}'>{{$val["name"]}}</a>
		@endforeach
	@endif
@stop

@section('content')

	@if(Auth::check())
		<a href="auth/logout">로그아웃</a>
	@endif
	{{-- 고시원 등록 --}}
	<a href="home/tel-register">새 고시원 등록</a>
	{{-- 총무 신청 --}}
	<a href="home/application">총무 신청</a>
	{{-- 사용설명서 --}}
	<a href="home/manual">Smalltels 사용법</a>
	{{-- 개인정보관리 --}}
	<a href="home/admin">개인정보 관리</a>
	{{-- 각 고시원별 이동 탭 --}}
	{{-- <a href="">@각고시원별 이동</a> --}}
	@if($tmp_message = Session::get('message'))
		<br>{{$tmp_message}}
	@endif
@stop