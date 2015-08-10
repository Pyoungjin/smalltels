{{-- ///////////////// --}}
				<div id="view_rtodo_list" class='span12' style="padding:3px; margin:0px; display:none;">
					<div class='span4 offset8'>
					 	<small>
					 	- 달력의 <i class="icon-ok-sign"></i>은 완료된 업무입니다.<br>
					 	- 달력의 <i class=" icon-ok-circle"></i>를 눌러 완료를 표시 할 수 있습니다. 
					 	</small>
					</div>
					<table class='table .table-condensed'>
		 			@foreach ($list as $rtodo)
					
						<tr >
							{{-- <td style=" height:20px;" colspan="{{$t = OTodo::info('t')}}">{{$rtodo['title']}}</td> --}}
							<td style=" height:20px;" colspan="16">{{$rtodo['title']}}</td>
						</tr>
						<tr>
							{{-- 	@if($i == date('j'))
									<td class='text-center' style=" text-align: center; background-color:#e5e5e5; width:14px; padding:0px; "> 
										{{$i}}
									</td>
								@else --}}
						@for($i=1; $i <=16; $i++)
									<td class='text-center' style='text-align: center; width:14px; padding:0px;' > 
										{{$i}}
									</td>
								{{-- @endif --}}
						@endfor
						</tr>

						<tr data-rtodo_id='{{$rtodo["id"]}}' style="">
						@for($i=1; $i <=16; $i++)
								@if(in_array($i, $rtodo['schedule']))
									@if(in_array($i,$rtodo['perform']))
										<td style="text-align: center; width:14px; padding:0px;">
											<i class="icon-ok-sign"></i>
										</td>
									@else
										<td style="text-align: center; width:14px; padding:0px; ">
											<div class='chk_perform' data-date='{{date("Y-m-").$i}}' data-rtodo_id="{{$rtodo['id']}}" style='cursor: pointer'>
												<i class=" icon-ok-circle"></i>
											</div>
										</td>
									@endif
								
								@else
								<td style=" text-align: center;"></td>
								@endif
						@endfor
						</tr>
						
						
						<tr>
						@for($i=17; $i <=32; $i++)
									<td class='text-center' style=" text-align: center; width:14px; padding:0px; "> 
										{{($i > date('t'))?'':$i}}
									</td>
						@endfor
						</tr>
						<tr data-rtodo_id='{{$rtodo["id"]}}' style="border-bottom: 3px solid #333;">
						@for($i=17; $i <=32; $i++)
								@if(in_array($i, $rtodo['schedule']))
									@if(in_array($i,$rtodo['perform']))
										<td style="text-align: center; width:14px; padding:0px;">
											<i class="icon-ok-sign"></i>
										</td>
									@else
										<td style="text-align: center; width:14px; padding:0px; ">
											<div class='chk_perform' data-date='{{date("Y-m-").$i}}' data-rtodo_id="{{$rtodo['id']}}" style='cursor: pointer'>
												<i class=" icon-ok-circle"></i>
											</div>
										</td>
									@endif
								
								@else
								<td style=" text-align: center;"></td>
								@endif
						@endfor
						</tr>
					
					@endforeach
					</table>
				</div>
				{{-- //////////// --}}