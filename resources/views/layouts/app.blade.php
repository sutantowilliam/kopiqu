<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kopiqu</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { 
            padding-top: 70px;
            background-image:url('/img/background.jpg');
            height: 100%; 
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover; }
    </style>
    @yield('header')
</head>

<body>
    <div id="app">
        @include('layouts.navbar')
            
       <div class="container">
            @yield('content')
        </div>         
        
    </div>
@yield('footer')
</body>

</html>
