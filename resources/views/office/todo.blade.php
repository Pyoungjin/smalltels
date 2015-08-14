@extends('layouts.office')

@section('title')
	To do
@stop

@section('head')
	@parent

	
@stop

@section('function')
	
	{{-- @include('parts.month_component') --}}
@stop

@section('content')
	{{-- @include('parts.date_component') --}}
	{{-- 기증 버튼 --}}
	<div class='row'>
		<div class='span3 offset1'>
			<h4>{{date('Y년 m월 d일')}}</h4>
		</div>
		
	</div>
	
	{{-- 할일 리스트 --}}
	<div class='row'>
		<div class='span10 offset1'>
			<div class='row'>
				<div class='span2'>
					<h4>고정 업무</h4>
					
				</div>
				<div class='span7'>
					
				</div>
				<div class='span1 '>
					{{-- 새로운 RTodo 만들기 --}}
					<a href="#createRTodo" role="button" class="btn btn-primary" data-toggle="modal">
						<i class="icon-plus icon-white"></i> 
					</a>
					
					
					{{-- 기존 RTodo 수정 --}}
					{{-- <a href="#editRTodo" role="button" class="btn" data-toggle="modal">할 일 수정</a> --}}
				</div>
			</div>

			<div class="row-fluid" style='border:2px #e5e5e5 solid; border-radius: 4px;padding:5px;'>
				<div class='span12' style='border-bottom: 1px #aaa solid; padding: 3px; margin-bottom: 5px;'>
					고정 업무가 {{count(OTodo::info('today_schedule'))}} 개가 있습니다.
					총 고정 업무는 {{count($list=OTodo::info('rtodo_list'))}} 개 입니다.
				</div>
				@if(!$list)
				<div class='span8'>
					위에 있는
					<a class="btn btn-primary">
						<i class="icon-plus icon-white"></i> 
					</a>
					버튼을 눌러 새로운 업무를 등록해주세요.
				</div>
				@endif
				@foreach (OTodo::info('today_schedule') as $rtodo_id)
				<div class='span8'>
					{{($rtodo=OTodo::rtodo($rtodo_id))?$rtodo['title']:''}}
				</div>
				<div class='span2 offset1'>
					@if(!in_array(date('j'),$rtodo['perform']))
					<button class='btn chk_perform' data-date='{{date('Y-m-d')}}' data-rtodo_id={{$rtodo['id']}}><i class="icon-ok"></i> 확인</button>
					@else
					<i class="icon-ok-sign"></i> 완료
					@endif
				</div>
				@endforeach
				@if($list)
				<div class='span12'>
					<a id='btn_rtodo_list' class='btn btn-link'> >>전체보기</a>
				</div>
				@endif
				@include('office.modal.todo_rtodo_list')	
			
			</div>


			
		</div>
	</div>

	
	@include('office.modal.todo_create_rtodo')
	@include('office.modal.todo_edit_rtodo')
	
@stop

@section('javascript')
<script type="text/javascript">

//script구문 내부에 해당 메소드를 입력합니다.
 // $(function() {
$( "#standard_date" ).datepicker({
		monthNames: [ "1","2","3","4","5","6","7","8","9","10","11","12"],
		maxDate: "+30d",
		minDate: "0d",
		dateFormat: "yy-mm-dd",
	});
  // });
  // 
$(".btn-standard_date").click(function(){
	$("#standard_date").focus();
	});

$("#create_type").change(function(){
	$("#create_interval").html(function(){
		var v = $(".type").val();
		if(v == 'period'){
			return strPeriod();
		}else if(v == 'monthly'){
			return strMonthly();
		}else if(v == 'weekly'){
			return strWeekly();
		}
	});
});

$('#create_interval').change(function(){

	var v = $('#create_interval').val();
	if( v > 28 && v <= 31)
	{
		if($('#create_type').val() == 'monthly')
		{
			$("#create_body").append(
				'<div class="alert alert-info">'
					+ '<button type="button" class="close" data-dismiss="alert">&times;</button>'
					+ '<h4>Warning!</h4>'
					+ '28일 이후의 날짜는 당 월에 없을수도 있습니다.<br> '
					+ '만약 매월 마지막 날을 원하시면 <strong>\'마지막 날\'</strong>을 선택해주세요.'
				+'</div>'
				);
		}
	}
});

$('.chk_perform').click(function(){
	$('#frm_perform_rtodo_id').val(
		$(this).data('rtodo_id')
		);
	$('#frm_perform_date').val(
		$(this).data('date')
		);
	$('#frm_perform').submit();
});

$( "#btn_rtodo_list" ).click(function() {
  $( "#view_rtodo_list" ).fadeToggle( "fast", "easeOutExpo",function() {
  	if($( "#view_rtodo_list" ).css('display') == 'none'){
    	$( "#btn_rtodo_list" ).html( "<< 전체보기" );
	}else{
		$( "#btn_rtodo_list" ).html( ">> 접기" );
	}
  });
});

function strPeriod(){
	var s = "";
	for (var i = 1; i <= 30; i++) {
		s += "<option value='"+i+"'>"+i+"일 간격</option>";
	};

	return s;
}

function strWeekly(){
	return "<option value='1'>월요일</option>"
	+"<option value='2'>화요일</option>"
	+"<option value='3'>수요일</option>"
	+"<option value='4'>목요일</option>"
	+"<option value='5'>금요일</option>"
	+"<option value='6'>토요일</option>"
	+"<option value='0'>일요일</option>";
}

function strMonthly(){
	var tmp_str = "";
	for (var i = 1; i <= 31; i++) {
		tmp_str += "<option value='"+i+"'>"+i+"일</option>"
	};
	tmp_str += "<option value='0'>마지막 날</option>";

	return tmp_str;
}
</script>
@stop