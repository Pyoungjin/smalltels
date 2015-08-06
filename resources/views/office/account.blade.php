@extends('layouts.office')

@section('title')
    Office Account
@stop

@section('head')
	@parent

	
@stop

@section('content')
	@include('parts.month_component')
	
	@if(!STDate::info('search_available'))
		<div class='row'>
			<div class='span10 offset1'>
				<div class="alert alert-error">
					<strong>에러!</strong> 비정상적인 접속입니다. 
				</div>
			</div>
		</div>
	@else
		<div class='row'>
			<div class='span10 offset1'>
				<form class='form-inline text-center' action="/{{Request::Path()}}/recoder" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
					<input type="hidden" name="target_month" value="{{ Request::input('search_month') }}"> 
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
					<span>수입:{{number_format($revenue = OAccount::info('revenue'))}} / </span>
					<span>지출:{{number_format($expense = OAccount::info('expense'))}} / </span>
					<span>합계:{{number_format($amount = OAccount::info('amount'))}}</span>
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
						<td style='text-align: right'>{{number_format($val['price'])}}</td>
						<td></td>
						@elseif($val['action'] == 'expense')
						<td></td>
						<td style='text-align: right'>{{number_format($val['price'])}}</td>
						@endif
						<td style='text-align: center'>{{$val['user_id']}}</td>
					</tr>
				@endforeach
					<tr>
						<td style='text-align: center'><h5>총계</h5></td>
						<td ></td>
						<td style='text-align: right'><h5>{{number_format($revenue)}} 원</h5></td>
						<td style='text-align: right'><h5>{{number_format($expense)}} 원</h5></td>
						<td style='text-align: center'><h5>{{number_format($amount)}} 원</h5></td>
					</tr>
				</table>
			</div>
		</div>
		@else
		<div class='row'>
			<div class='span10 offset1'>
					<div class="alert">
						<strong>해당 자료가 없습니다.</strong>
					</div>
			</div>
		</div>
		@endif
	@endif
@stop