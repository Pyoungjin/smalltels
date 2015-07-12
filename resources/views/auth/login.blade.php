@extends('layouts.master')

@section('title', 'Page Title')

@stop

@section('content')
    <div style="border: 1px solid #232420;">
	    <form method="post">
	    	email : <input type="text" placeholder="example@email.com">
	    	PW    : <input type="passwords" placeholder="passwords">
	    	<input type="submit" value="LogIn">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    </form>
    </div>
@stop