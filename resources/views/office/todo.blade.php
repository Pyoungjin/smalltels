@extends('layouts.office')

@section('title')
	To do
@stop

@section('head')
	@parent

	
@stop

@section('function')
	<div class='row'>
		<div class='span12'>
			{{-- 새로운 RTodo 만들기 --}}
			<a href="#createRTodo" role="button" class="btn btn-primary" data-toggle="modal">새로운 할 일 만들기</a>
			 
			<div id="createRTodo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<form action='/{{Request::path()}}/r-todo' method='post' style='margin:0px;'>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">새로운 할 일 만들기</h3>
					</div>
					<div id="create_body" class="modal-body">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="input-prepend">
							<span class="add-on">제목</span>
							<input name='title' type="text" class='span5' placeholder='ex) 화장실 청소'>
						</div><br>
						<div class="input-prepend input-append">
							<span class="add-on">시작</span>
							<input name='standard_date' type="text" id="standard_date" value="{{date('Y-m-d')}}">
							<button class="btn btn-standard_date" type="button">
								<i class="icon-calendar"></i>
							</button>

						</div><br>
						<div class="input-prepend">
							<span class="add-on">주기</span>
							<select id='create_type' name='type' class='type span2 offset1'>
								<option value="period">정기적으로</option>
								<option value="monthly">매달마다</option>
								<option value="weekly">매주마다</option>
							</select>
						</div>
						<div class="input-append">
							<select id='create_interval' name='interval' class='span2'>
							@for($i = 1 ; $i < 32 ; $i++ )
								<option value='{{$i}}'>{{$i}}일 간격</option>
							@endfor
							</select>
							{{-- <span class="add-on">마다</span> --}}
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<input type="submit" class='btn btn-primary' value="만들기">
					</div>
				</form>
			</div>
			{{-- 기존 RTodo 수정 --}}
			<a href="#editRTodo" role="button" class="btn" data-toggle="modal">기존 할일 수정</a>
			<div id="editRTodo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">기존 할일 수정</h3>
				</div>
				<div class="modal-body">
					qwe
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					<input type="submit" class='btn btn-primary' value="수정하기">
				</div>
			</div>
		</div>
	</div>
	
	@include('parts.month_component')
@stop

@section('content')
	<div>
							
		<h1>Todo List</h1>
		{{var_dump(OTodo::info())}}
		
	</div>
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