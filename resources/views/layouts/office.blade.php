<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/assets/CSS/css_reset.css">
        <title>Smalltels - @yield('title')</title>
    </head>
    <body>
        <div style='border-bottom: 3px solid black; margin: 5px; '>
            @section('head')
                <a href="/home">HOME</a>
                @if(Auth::check())
                    <a href="auth/logout">로그아웃</a>
                @endif
            @show
        </div>
        <div style='border-bottom: 3px solid black; margin: 5px; '>
            @section('sidebar')
                <a href="/office/{{Office::office('tels_id')}}/board">알림/메세지</a>
                <a href="/office/{{Office::office('tels_id')}}/todo">할일</a>
                <a href="/office/{{Office::office('tels_id')}}/account">회계</a>
                <a href="/office/{{Office::office('tels_id')}}/room">방관리</a>
                <a href="/office/{{Office::office('tels_id')}}/tenant">세입자</a>
                <a href="/office/{{Office::office('tels_id')}}/setup">고시원 세팅 </a>
            @show
        </div>
        <div class="container">

            @yield('content')
        </div>
    </body>
</html>  