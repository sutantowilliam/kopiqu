<html>
    <head>
        <title>Kopiqu - @yield('title')</title>
        <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        @yield('header')
    </head>
    <body>
        @include('layouts.navbar')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>