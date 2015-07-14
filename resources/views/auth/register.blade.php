@extends('layouts.welcome')

@section('title', 'Page Title')

@stop

@section('content')
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
    <div style="border: 1px solid #232420;">
	    <form method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	name  : <input name="name" type="text" placeholder="example@email.com"><br>
	    	email : <input name="email" type="text" placeholder="example@email.com"><br>
	    	PW    : <input name="password" type="password" placeholder="passwords" min=6><br>
	    	PW 확인: <input name="password_confirmation" type="password" placeholder="passwords"><br>
	    	{{-- PW    : <input type="passwords" placeholder="password"> --}}
	    	<input type="submit" value="Register">
	    </form>
    </div>
@stop