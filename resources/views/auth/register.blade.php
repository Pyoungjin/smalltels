@extends('layouts.master')

@section('title', 'Page Title')

@stop

@section('content')
    <div style="border: 1px solid #232420;">
	    <form method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	name : <input name="name" type="text" placeholder="example@email.com">
	    	email : <input name="email" type="text" placeholder="example@email.com">
	    	PW    : <input name="password" type="password" placeholder="passwords">
	    	{{-- PW    : <input type="passwords" placeholder="password"> --}}
	    	<input type="submit" value="Register">
	    </form>
    </div>
@stop