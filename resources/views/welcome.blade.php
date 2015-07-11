@extends('layouts.master')

@section('title', 'Page Title')

@stop

@section('content')
    <div style="border: 1px solid #232420;">
	    <form action="auth/register" method="post">
	    	name : <input name="name" type="text" placeholder="example@email.com">
	    	email : <input name="email" type="text" placeholder="example@email.com">
	    	PW    : <input name="password" type="password" placeholder="passwords">
	    	{{-- PW    : <input type="passwords" placeholder="password"> --}}
	    	<input type="submit" value="sign up">
	    </form>
    </div>

    <div style="border: 1px solid #232420;">
	    <form action="auth/register" method="post">
	    	email : <input type="text" placeholder="example@email.com">
	    	PW    : <input type="passwords" placeholder="passwords">
	    	<input type="submit" value="log in">
	    </form>
    </div>
@stop