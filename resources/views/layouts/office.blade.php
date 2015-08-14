<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Smalltels - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/css_reset.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


        <style>
            body{
                padding-top: 45px;
                /*background-color: #ddd;*/
            }
            /*.container{
                background-color: #fff;
            }*/
        
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
    {{-- 고시원 기능 --}}
        <div class='row'>
            <div class='span12'>
                <div class="navbar">
                    <div class="navbar-inner">
                        <ul class='nav'>
                            <li class="{{(Request::is('*/board'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/board">알림/메세지</a>
                            </li>
                            <li class="{{(Request::is('*/todo'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/todo">할일</a>
                            </li>
                            <li class="{{(Request::is('*/account'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/account">회계</a>
                            </li>
                            <li class="{{(Request::is('*/room'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/room">방관리</a>
                            </li>
                            <li class="{{(Request::is('*/tenant'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/tenant">세입자</a>
                            </li>
                            <li class="{{(Request::is('*/setup'))?'active':''}}">
                                <a href="/office/{{Office::info('id')}}/setup">고시원 세팅 </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @yield('function')
        @yield('content')

    
    </div>
    @yield('modal')
    {{-- javascript --}}
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    @yield('javascript')


    </body>
</html>  