@extends('layouts.nakedForms')

@section('page.title', ' - Вход')

@section('nakedForms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-4 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <h1 class="display-6 text-center mb-4">{{ __('Авторизация') }}</h1>

            <x-errors />
            <form method="post" action="{{ route('login.store') }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Логин') }}</label>
                    <input type="text" class="form-control" value="{{ old('login') }}" name="login" id="login" autocomplete="off" autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">{{ __('Пароль') }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" tabindex="1">
                </div>

                <button class="btn btn-primary w-100" type="submit" tabindex="2">{{ __('Войти') }}</button>
            </form>

        </div>
    </div>
@endsection
