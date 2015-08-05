@extends('layouts.office')

@section('title')
    Office Account
@stop

@section('head')
	@parent

	
@stop

@section('content')
	<div class='row'>
		<div class='span12 '>
			<ul class="pager inline">
				@if(OAccount::info('pre_month') < '2015-06')
				<li class='disabled'>
	    			<a href="#">&larr; 이전</a>
	  			</li>
				@else
				<li>
	    			<a href="/{{Request::path()}}?date={{OAccount::info('pre_month')}}">&larr; 이전</a>
	  			</li>
				@endif
				
		  		<li>
		  			<h4>{{date_create(OAccount::info('search_month'))->format('Y년 m월')}}</h4>

		  		</li>
		  		@if(OAccount::info('next_month') > date('Y-m'))
		  		<li class="disabled">
		    		<a href="#">이후 &rarr;</a>
		  		</li>
		  		@else
		  		<li>
		    		<a href="/{{Request::path()}}?date={{OAccount::info('next_month')}}">이후 &rarr;</a>
		  		</li>
		  		@endif
			</ul>
		</div>
	</div>
	<div class='row'>
		<div class='span10 offset1'>
			<form class='form-inline text-center' action="/{{Request::Path()}}/recoder" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
				<input type="hidden" name="date" value="{{ Request::input('date') }}"> 
				<div class="input-prepend">
					<span class="add-on">내용</span>
					<input type="text" name="content" placeholder="ex) 101호 세입자 방세 납입">
				</div>
				<select class='span1' name='action'>
					<option value="revenue">수입</option>
					<option value="expense">지출</option>
				</select>
				<div class="input-append">
					<input type="text" name="price" placeholder="100000">
					<span class="add-on">원</span>
				</div>
				
				<input class='btn btn-primary' type="submit" value="기록하기">
			</form>
			{{-- </div> --}}
		</div>
	</div>
	
	@if(count($ledger = OAccount::info('ledger')))
	<div class='row'>
		<div class='span10 offset1'>
			<div class='text-right' style='padding:7px 10px;'>
				<span>{{date('Y-m-d')}} 기준 - </span>
				<span>수입:{{$revenue = OAccount::info('revenue')}} / </span>
				<span>지출:{{$expense = OAccount::info('expense')}} / </span>
				<span>합계:{{$amount = OAccount::info('amount')}}</span>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='span10 offset1'>
			<table class='table table-striped'>
				<tr>
					<td style='text-align: center; width:170px'>날짜</td>
					<td style='text-align: center; '>내용</td>
					<td style='text-align: center; width:80px;'>수입</td>
					<td style='text-align: center; width:80px;'>지출</td>
					<td style='text-align: center; width:100px;'>처리</td>
				</tr>
			@foreach ($ledger as $val) 
				<tr>
					<td style='text-align: center'>{{$val['date']}}</td>
					<td style='text-align: left'>{{$val['content']}}</td>
					@if($val['action'] == 'revenue')
					<td style='text-align: right'>{{$val['price']}}</td>
					<td></td>
					@elseif($val['action'] == 'expense')
					<td></td>
					<td style='text-align: right'>{{$val['price']}}</td>
					@endif
					<td style='text-align: center'>{{$val['id']}}</td>
				</tr>
			@endforeach
				<tr>
					<td style='text-align: center'><h5>총계</h5></td>
					<td ></td>
					<td style='text-align: right'><h5>{{$revenue}} 원</h5></td>
					<td style='text-align: right'><h5>{{$expense}} 원</h5></td>
					<td style='text-align: center'><h5>{{$amount}} 원</h5></td>
				</tr>
			</table>
		</div>
	</div>
	@else
	<div class='row'>
		<div class='span10 offset1'>
			@if(OAccount::info('search_month') > date('Y-m') || OAccount::info('search_month') < '2015-06')
				<div class="alert alert-error">
					{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
					<strong>에러!</strong> 비정상적인 접속입니다. 
				</div>
			@else
				<div class="alert">
					{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
					<strong>해당 자료가 없습니다.</strong>
				</div>
			@endif
		</div>
	</div>
	@endif
@stop