@extends('layouts.home')

@section('title', '총무 신청')

@stop

@section('content')
     <div style="border: 1px solid #232420;">
	    <form method="post">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	{{-- 고시원 이름  : <input name="name" type="text" placeholder="스몰텔 고시원"><br>
	    	고시원 전화번호 : <input name="phone" type="text" placeholder="021231234"><br>
	    	고시원 주소 : <input name="address" type="text"><br> --}}

	    	고시원 등록 번호 : <input name="tel_id" type="text" placeholder="고시원 등록번호는 자동으로 채워집니다."><br>
	    	<input type="submit" value="신청하기">
	    </form>
    </div>

@stop