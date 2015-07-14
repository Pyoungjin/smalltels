@extends('layouts.welcome')

@section('title', 'Page Title')

@stop

@section('content')
    <div style="border: 1px solid #232420;">
    	<strong>로그인하기</strong>
	    <form action="/auth/login" method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	email : <input name='email' type="text" placeholder="example@email.com">
	    	PW    : <input name='password' type="password" placeholder="passwords">
	    	<input type="submit" value="LogIn">
	    </form>
    </div>
    @if(!$errors->isEmpty())
		<div id="errors_section">
			에러있음
			<br>
			@foreach ($errors->all() as $error)
				{{$error}}
				<br>
			@endforeach
		</div>
	@endif
@stop