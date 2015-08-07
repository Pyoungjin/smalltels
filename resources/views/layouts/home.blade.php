<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Smalltels - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/css_reset.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
        <style>
            body{
                padding-top: 45px;
            }
        
        </style>
        @yield('css')
    </head>
    <body>
    {{-- 최상단 메뉴 --}}
    @include('parts.top_head')
    <div class='container'>
    {{-- 홈/고시원 선택 --}}
        @include('parts.top_navi')
    {{-- alert 표시 --}}
        @include('parts.alert_bar')
    </div>
    <div class='container'>
        <div class='row' style='margin-bottom: 20px;'>
            <div class='span12'>
    {{-- home --}}
                <a class='btn' href="/home">Home</a>

    {{-- 고시원 등록 --}}
                <a class='btn' href="/home/tel-register">고시원 등록</a>
    {{-- 총무 신청 --}}
                <a class='btn' href="/home/application">총무 신청</a>
    {{-- 사용설명서 --}}
                <a class='btn' href="/home/manual">Smalltels 사용법</a>
    {{-- 개인정보관리 --}}
                <a class='btn' href="/home/admin">마이페이</a>
            </div>
        </div>
        @yield('function')
        @yield('content')
        
    </div>
    {{-- javascript --}}
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @yield('javascript')
    </body>
</html>  