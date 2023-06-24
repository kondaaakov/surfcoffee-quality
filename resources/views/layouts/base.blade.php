<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/scss/styles.scss', 'resources/js/app.js'])

    @stack('css')

    <title>{{ config('app.name') }} @yield('page.title', '')</title>
</head>
<body>

@yield('content')

@stack('js')
</body>
</html>
