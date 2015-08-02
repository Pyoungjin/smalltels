<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Smalltels - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/css_reset.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
        @yield('css')
    </head>
    <body>

        <div style='border-bottom: 3px solid black; margin: 5px; '>
            @section('head')
                <a href="/home" style="background-color: blue; color: white;">HOME</a>
                @if(User::check())
                    <a href="/auth/logout">로그아웃</a>
                    @if(count($list = User::info('office_list')))
                        @foreach ( $list as $val)
                        {{-- {{var_dump($val)}} --}}
                            <a href='/office/{{$val["id"]}}/board'>{{$val["name"]}}</a>
                        @endforeach
                    @endif
                @endif


            @show
        </div>
        <div class="container">

            @yield('content')
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
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        @yield('javascript')
    </body>
</html>  