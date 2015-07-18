@extends('layouts.office')

@section('title', 'Page Title')


@section('head')
	@parent
		{{-- {{123}} --}}
	@if(($list = TelsList::telsList()) != null)
		@foreach ( $list as $val)
		{{-- {{var_dump($val)}} --}}
			<a href='/office/{{$val["id"]}}/board'>{{$val["name"]}}</a>
		@endforeach
	@endif
@stop

@section('content')
	<div>내용내용</div>
@stop