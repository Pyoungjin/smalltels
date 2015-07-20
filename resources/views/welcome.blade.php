@extends('layouts.welcome')

@section('title', 'Page Title')

@stop

@section('content')
	@if(!Auth::check())
		<h1>로그인 또는 가입 해주세요.</h1><br>
	@else
		<a href="/auth/logout"><h1>로그 아웃</h1></a><br>
	@endif
    <div style="border: 1px solid #232420;">
    	<strong>가입하기</strong>
	    <form action="/auth/register" method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	name  : <input name="name" type="text" placeholder="my name is..."><br>
	    	email : <input name="email" type="text" placeholder="example@email.com"><br>
	    	PW    : <input name="password" type="password" placeholder="passwords" ><br>
	    	PW 확인: <input name="password_confirmation" type="password" placeholder="passwords"><br>
	    	<input type="submit" value="Register">
	    </form>
    </div>
    <br>
    <div style="border: 1px solid #232420;">
    	<strong>로그인하기</strong>
	    <form action="/auth/login" method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	email : <input name='email' type="text" placeholder="example@email.com">
	    	PW    : <input name='password' type="password" placeholder="passwords">
	    	<input type="submit" value="LogIn">
	    </form>
    </div>
      {{-- error.start --}}
        @if(!$errors->isEmpty())
            <br><br><br>
            <div id="errors_section">
                에러있음
                <br>
                @foreach ($errors->all() as $error)
                    {{$error}}
                    <br>
                @endforeach
            </div>
        @endif
    {{-- error.end --}}
    {{-- message.start --}}
        @if($tmp_message = Session::get('message'))
            <br><br><br>
            <br>{{$tmp_message}}
        @endif
    {{-- message.end --}}
@stop