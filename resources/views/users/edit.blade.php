@extends('layouts.forms')

@section('page.title', ' - Редактирование пользователя')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('users') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">{{ __('Редактирование пользователя') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('users.update', $user->id) }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Логин') }}</label>
                    <input type="text" class="form-control" value="{{ $user->login ?? '' }}" name="login" id="login" autocomplete="off" tabindex="3">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Пароль') }}</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" tabindex="4">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Почта') }}</label>
                    <input type="email" class="form-control" value="{{ $user->email ?? '' }}" name="email" id="email" autocomplete="off" tabindex="5">
                </div>

                <div class="mb-3">
                    <label for="group_id" class="form-label">{{ __('Группа') }}</label>
                    <select class="form-select" name="group_id" id="group_id" autocomplete="off" tabindex="8">
                        <option selected disabled>Выбрать группу</option>
                        @foreach($groups as $group)
                            <option {{ $group->id === $user->group_id ? 'selected' : '' }} value="{{ $group->id }}">{{ __($group->title) }}</option>
                        @endforeach

                    </select>
                </div>

                <h3 class="mb-4">Профиль пользователя</h3>

                <div class="mb-3">
                    <label for="firstname" class="form-label">{{ __('Имя') }}</label>
                    <input type="text" class="form-control" value="{{ $user->firstname ?? '' }}" name="firstname" id="firstname" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">{{ __('Фамилия') }}</label>
                    <input type="text" class="form-control" value="{{ $user->lastname ?? '' }}" name="lastname" id="lastname" autocomplete="off" tabindex="2">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Номер телефона') }}</label>
                    <input type="tel" class="form-control" value="{{ $user->phone ?? '' }}" name="phone" id="phone" autocomplete="off" tabindex="6">
                </div>

                <div class="mb-3">
                    <label for="telegram_nickname" class="form-label">{{ __('Telegram') }}</label>
                    <input type="text" class="form-control" value="{{ $user->telegram_nickname ?? '' }}" name="telegram_nickname" id="telegram_nickname" autocomplete="off" tabindex="7">
                </div>

                <button class="btn btn-success w-100" type="submit" tabindex="9">{{ __('Редактировать') }}</button>
            </form>

        </div>
    </div>

@endsection
