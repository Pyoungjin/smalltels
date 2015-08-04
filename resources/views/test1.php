<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Smalltels - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/css_reset.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
        <style>
            body{
                padding-top: 45px;
            }
        
        </style>
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
    </head>
    <body>
    <div class='row'>
    <div class='span12'>
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <ul class='nav pull-right'>
                  
                    <li >
                        <a href="/auth/register">회원가입</a>
                    </li>
                    <li >
                        <a href="/auth/login">로그긴</a>
                    </li>

                    
                </ul>
            </div>
        </div>
    </div>
</div>
    <div class='container'>


        <div class='text-center'>
    <br><br>
            <h1>로그인 또는 가입 해주세요</h1>
        </div>
        <br>
        <br>
        <br>
        <br>

    <div class='row '>
        
        <div class='span4 offset1 ' >
            <div class='text-center'>
               <h3>가입하기</h3>
            </div>
            <div class="box">
                <div style='width:220px; margin: 20px auto;'>
                    <form action="/auth/register" method="post">
                        
                        
                        <input type="hidden" name="_token" value="<?php csrf_token() ?>">
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
                        <input type="hidden" name="_token" value="<?php csrf_token() ?>">
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">email</label>
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
                            <div class="controls pull-right">
                                <input type="submit" value="Login" class='btn'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    </body>
</html>  