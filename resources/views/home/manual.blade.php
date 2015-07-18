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
    사용법입니다.
@stop