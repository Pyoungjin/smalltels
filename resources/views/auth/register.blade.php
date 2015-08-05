@extends('layouts.welcome')

@section('title')
    회원가입
@stop

@section('css')
    <style>
        .box{
            border:2px solid #eee; 
            border-radius: 5px; 
            height:370px;
        } 
        .box:hover, .box:focus{
            border-color: #333;
        }
    </style>
@stop

@section('content')
    <div class='row'>
	    <div class='span4 offset4'>
	        <div class='text-center'>
               <h3>가입하기</h3>
            </div>
            <div class="box">
                <div style='width:220px; margin: 20px auto;'>
                    <form action="/auth/register" method="post">
                        
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="control-group">
                            <label class="control-label" for="inputName">name</label>
                            <div class="controls">
                                <input name="name" type="text" placeholder="my name is...">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">email</label>
                            <div class="controls">
                                <input name="email" type="text" placeholder="example@email.com">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPw">PW</label>
                            <div class="controls">
                                <input name="password" type="password" placeholder="passwords" >
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputRePw">PW 확인</label>
                            <div class="controls">
                                <input name="password_confirmation" type="password" placeholder="passwords">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls pull-right">
                                <input type="submit" value="Register" class='btn'>
                            </div>
                        </div>
                     
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop