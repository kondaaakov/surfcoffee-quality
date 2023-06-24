@extends('layouts.base')

@section('content')

    <div class="d-flex flex-column justify-content-between min-vh-100">
        @include('includes.header')

        <div class="form-container py-4 flex-grow-1">
            <div class="container">
                @yield('forms.content')
            </div>
        </div>

        @include('includes.footer')
    </div>

@endsection

@once

    @push('css')
        <style>
            .form-container {
                background-image: url('{{ Vite::asset('resources/images/bg.webp') }}');
            }
        </style>
    @endpush

@endonce
