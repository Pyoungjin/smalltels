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