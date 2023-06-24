@extends('layouts.forms')

@section('page.title', ' - Создание пользователя')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-4 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <h1 class="display-6 text-center mb-4">{{ __('Создание пользователя') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('users.store') }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Логин') }}</label>
                    <input type="text" class="form-control" value="{{ old('login') }}" name="login" id="login" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Пароль') }}</label>
                    <input type="password" class="form-control" value="{{ old('password') }}" name="password" id="password" autocomplete="off" tabindex="1">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Почта') }}</label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" autocomplete="off" tabindex="1">
                </div>

                <div class="mb-3">
                    <label for="group_id" class="form-label">{{ __('Группа') }}</label>
                    <select class="form-select" name="group_id" id="group_id" autocomplete="off" tabindex="1">
                        <option selected disabled>Выбрать группу</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ __($group->title) }}</option>
                        @endforeach

                    </select>
                </div>

                <button class="btn btn-primary w-100" type="submit" tabindex="2">{{ __('Создать') }}</button>
            </form>

        </div>
    </div>

@endsection
