@extends('layouts.forms')

@section('page.title', ' - Создание пользователя')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('users') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">{{ __('Создание пользователя') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('users.store') }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="firstname" class="form-label">{{ __('Имя') }}</label>
                    <input type="text" class="form-control" value="{{ old('firstname') }}" name="firstname" id="firstname" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">{{ __('Фамилия') }}</label>
                    <input type="text" class="form-control" value="{{ old('lastname') }}" name="lastname" id="lastname" autocomplete="off" autofocus>
                </div>

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
                    <label for="phone" class="form-label">{{ __('Номер телефона') }}</label>
                    <input type="tel" class="form-control" value="{{ old('phone') }}" name="phone" id="phone" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="telegram_nickname" class="form-label">{{ __('Telegram') }}</label>
                    <input type="text" class="form-control" value="{{ old('telegram_nickname') }}" name="telegram_nickname" id="telegram_nickname" autocomplete="off" autofocus>
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
