<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    @yield('styles')
    <title>@yield('title')</title>
</head>
<body>

@auth
@include('layouts.navigation_bar')
@endauth

@yield('content')
</body>
<script src="{{mix('js/app.js')}}"></script>
</html>
