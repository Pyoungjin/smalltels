@extends('layouts.welcome')

@section('title', 'Page Title')

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
	
    <div class='text-center'>
            <h1>로그인 또는 가입 해주세요</h1>
        </div>
    {{-- <div class='row hero-unit'> --}}
    <div class='row '>
        
        <div class='span4 offset1 ' >
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
                            <div class="controls">
                                <input type="submit" value="Register" class='btn'>
                            </div>
                        </div>
                     
                        
                    </form>
                </div>
            </div>
        </div>
        <div class='span2 text-center' style='padding-top:150px; color: #999;'>
            <h3>OR</h3>
        </div>


        <div class='span4'>
            <div class='text-center'>
                <h3>로그인하기</h3>
            </div>
           
            <div class='box'>
                <div style='width:220px; margin: 20px auto;'>
                    <form action="/auth/login" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="control-group">
                            <label class="control-label" for="inputRePw">email</label>
                            <div class="controls">
                                <input name='email' type="text" placeholder="example@email.com">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputRePw">PW</label>
                            <div class="controls">
                                <input name='password' type="password" placeholder="passwords">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="submit" value="Login" class='btn'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        {{-- <div class='span2'>
        </div> --}}
    </div>



      {{-- error.start --}}
        @if(!$errors->isEmpty())
            <br><br><br>
            <div id="errors_section">
                에러있음
                <br>
                @foreach ($errors->all() as $error)
                    {{$error}}
                    <br>
                @endforeach
            </div>
        @endif
    {{-- error.end --}}
    {{-- message.start --}}
        @if($tmp_message = Session::get('message'))
            <br><br><br>
            <br>{{$tmp_message}}
        @endif
    {{-- message.end --}}

@stop

@section('javascript')
<script>

</script>
@stop
