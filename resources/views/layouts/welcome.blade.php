<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Smalltels - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/css_reset.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
        @yield('css')

    </head>
    <body>
        <div class='container'>
        @yield('content')
        </div>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        @yield('javascript')
    </body>
</html>  