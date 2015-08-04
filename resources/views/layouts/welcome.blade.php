<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
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
    {{-- alert 표시 --}}
        @include('parts.alert_bar')

        @yield('content')
    </div>
    {{-- javascript --}}
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @yield('javascript')
    </body>
</html>  