<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ Vite::asset('resources/images/general/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ Vite::asset('resources/images/general/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ Vite::asset('resources/images/general/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Vite::asset('resources/images/general/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ Vite::asset('resources/images/general/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ Vite::asset('resources/images/general/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ Vite::asset('resources/images/general/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ Vite::asset('resources/images/general/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/images/general/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ Vite::asset('resources/images/general/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/images/general/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ Vite::asset('resources/images/general/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/general/favicon-16x16.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ Vite::asset('resources/images/general/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    @vite(['resources/scss/styles.scss', 'resources/js/app.js'])

    @stack('css')

    <title>{{ config('app.name') }} @yield('page.title', '')</title>
</head>
<body>

@yield('content')

@stack('js')
</body>
</html>
