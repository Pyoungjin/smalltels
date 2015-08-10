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
	@include('parts.date_component')
	{{-- 기증 버튼 --}}
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
	
	{{-- 할일 리스트 --}}
	<div class='row'>
		<div class='span12'>

			<table class='table'>
				@foreach (OTodo::info('today_schedule') as $rtodo_id)
					<tr>
						<td>
							{{($rtodo=OTodo::rtodo($rtodo_id))?$rtodo['title']:''}}
						</td>
						<td>
							@if(!in_array(date('j'),$rtodo['perform']))
							<button class='btn chk_perform' data-date='{{date('Y-m-').$i}}' data-rtodo_id={{$rtodo['id']}}><i class="icon-ok"></i></button>
							@else
							<i class="icon-ok-sign"></i> 완료
							@endif
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class='row'>
		<div class='span12'>
			@if(!count($list=OTodo::info('rtodo_list')))
			데이터 없음
			@else
	 			@foreach ($list as $rtodo)
				<table class='table'>
					<tr >
						<td style=" height:20px;" colspan="{{$t = OTodo::info('t')}}">{{$rtodo['title']}}</td>
					</tr>
					<tr>
						@for($i=1; $i <= $t; $i++)
							@if($i == date('j'))
								{{-- <td class='text-center' style=" text-align: center; background-color:#e5e5e5;">  --}}
								<td class='text-center' style=" text-align: center; background-color:#e5e5e5;"> 
									{{$i}}<span style='font-size:8px'>(Today)</span>
								</td>
							@else
								<td class='text-center' style='text-align: center; padding: 8px 7px; width:16px;' > 
									{{$i}}
								</td>
							@endif
						@endfor
					</tr>
					<tr data-rtodo_id='{{$rtodo["id"]}}' style="border-bottom: 3px solid #333;">
						@for($i=1; $i <= $t; $i++)
							@if(in_array($i, $rtodo['schedule']))
								@if(in_array($i,$rtodo['perform']))
									<td style="text-align: center;">
									{{-- <td style="text-align: center; {{($i == date('j'))?'background-color:#e5e5e5;':''}}"> --}}
										<i class="icon-ok-sign"></i>
									</td>
								@else
									@if($i == date('j'))
									<td style="text-align: center;">
									{{-- <td style="text-align: center; background-color:#e5e5e5;"> --}}
										<button class='btn chk_perform' data-date='{{date('Y-m-').$i}}' data-rtodo_id={{$rtodo['id']}}><i class="icon-ok"></i></button>
									</td>
									@else
									<td style="text-align: center; ">
										<i class="icon-minus"></i>
									</td>
									@endif
								@endif
							
							@else
							{{-- <td style=" text-align: center; {{($i == date('j'))?'background-color:#e5e5e5;':''}}"></td> --}}
							<td style=" text-align: center;"></td>
							@endif
						@endfor
					</tr>
				</table>
				
				@endforeach
			<form id='frm_perform' action='/{{Request::path()}}/perform' method='post' style='margin:0px;'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="rtodo_id" id='frm_perform_rtodo_id' value="">
				<input type="hidden" name="date" id='frm_perform_date' value="">
			</form>
 			@endif
		</tr>
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

$('.chk_perform').click(function(){
	$('#frm_perform_rtodo_id').val(
		$(this).data('rtodo_id')
		);
	$('#frm_perform_date').val(
		$(this).data('date')
		);
	$('#frm_perform').submit();
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