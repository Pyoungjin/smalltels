@extends('layouts.office')

@section('title')
	세입자
@stop

@section('head')
	@parent

	
@stop

@section('content')
	<div class='row' style=''>
		<div class='span1'>
			<h5>회원 목록</h5>
		</div>
		<div class='span1 offset10'>
			{{-- 새로운 tenant 만들기 --}}
			<a href="#createTenant" role="button" class="btn btn-primary " data-toggle="modal" style='maring: 5px;'>
				<i class="icon-plus icon-white"></i> 
			</a>
		</div>
	</div>
	

	<div class='row'>
		<div class='span12'>
			<table class='table table-hover'>
				<tr>
					<td class='span1' style="text-align: center;">번호</td>
					<td class='span2' style="text-align: center;">이름</td>
					<td class='span1' style="text-align: center;">상태</td>
					<td class='span2' style="text-align: center;">방</td>
					<td>특이사항</td>
				</tr>
				@if(!count(OTenant::info('list')))
				<tr >
					<td colspan="5">
						위에 있는
						<a class="btn btn-primary">
							<i class="icon-plus icon-white"></i> 
						</a>
						버튼을 눌러 새로운 회원을 등록해주세요.
					</td>
				</tr>
				@endif
				@foreach (OTenant::info('list') as $val)
				<tr class='tenant_section' data-tenant_id='{{$val["id"]}}' style='cursor: pointer;'>
					<td style="text-align: center;">{{$val['id']}}</td>
					<td>{{$val['name']}}</td>
					<td style="text-align: center;">
						@if(!count($val['room']))
							<span>대기중</span><br>
						@endif
						@foreach ($val['room'] as $v)
							@if($v['state'] == 'fill')
								<span>'입실'</span>
							@elseif($v['state'] == 'reservation')
								<span>'예약'</span>
							@endif
							<br>
						@endforeach
					</td>
					<td style="text-align: center;">
						@foreach ($val['room'] as $v)
							{{$v['name']}}<br>
						@endforeach
					</td>
					<td>
						{{(count($str_arr = str_split($val['notice'],17))>1)?$str_arr[0]."...":$str_arr[0]}}
					</td>
				</tr>
				@endforeach

			</table>
		</div>
	</div>
	{{-- <a id="btn_tenant_detail" data-toggle="modal" data-target="#tenant_detail">click me</a> --}}
	
	
@stop
@section('modal')
	@include('office.modal.tenant_create_tenant')
	@include('office.modal.default_frame')
	
@stop
@section('javascript')
<script type="text/javascript">
$('.tenant_section').click(function(){
	$('#default_frame #myModalLabel').html('입주자 세부 정보');
	var req = '/{{Request::path()}}/tenant-detail?tenant_id='+$(this).data('tenant_id');
	$('#default_frame > .modal-body').load(req, function(){
		$('#default_frame').modal();
	});
});

</script>
@stop