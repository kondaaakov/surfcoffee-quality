@extends('layouts.base')

@section('content')
    <div class="d-flex flex-column justify-content-between min-vh-100">
        @include('includes.header')

        <div class="container py-4 flex-grow-1">
            @yield('main.content')
        </div>

        @include('includes.footer')
    </div>
@endsection
