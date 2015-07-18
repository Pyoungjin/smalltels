@extends('layouts.home')

@section('title', '고시원 등록')

@stop

@section('head')
	@parent

	@if(($list = TelsList::telsList()) != null)
		@foreach ( $list as $val)
		{{-- {{var_dump($val)}} --}}
			<a href='/office/{{$val["id"]}}/board'>{{$val["name"]}}</a>
		@endforeach
	@endif
@stop

@section('content')
    <div style="border: 1px solid #232420;">
	    <form method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	고시원 이름  : <input name="name" type="text" placeholder="스몰텔 고시원"><br>
	    	고시원 주소 : <input name="address" type="text"><br>
	    	고시원 전화번호 : <input name="phone" type="text" placeholder="021231234"><br>
	    	<input type="submit" value="Register">
	    </form>
    </div>
@stop