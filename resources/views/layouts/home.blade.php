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
            @show
        </div>
        <div class="container">

            @yield('content')
        </div>
    </body>
</html>  