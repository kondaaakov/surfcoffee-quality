@extends('layouts.base')

@section('content')

    <div class="nakedForm-container">
        <div class="container">
            @yield('nakedForms.content')
        </div>
    </div>

@endsection

@once

    @push('css')
        <style>
            .nakedForm-container {
                background-image: url('{{ Vite::asset('resources/images/bg.webp') }}');
            }
        </style>
    @endpush

@endonce
