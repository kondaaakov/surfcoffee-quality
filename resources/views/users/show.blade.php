@extends('layouts.main')

@section('page.title', " - Пользователь $user->login")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('users') }}" class="link">Назад</a>
    </x-pageHeader>

    <section class="user">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">
                <a href="{{ route("users.edit", $user->id) }}" class="link me-2">Редактировать</a>
                <a href="{{ route("users.delete", $user->id) }}" onclick="return confirm('Удалить пользователя {{ $user->login }}?')" class="link text-danger">Удалить</a>
            </p>

            <p class="small text-muted mb-0"><b>Дата создания:</b> {{ $user->created_at->format('d.m.Y H:i') }}. <b>Дата изменения:</b> {{ $user->updated_at->format('d.m.Y H:i') }}</p>
        </div>

        <h1 class="display-4 mb-4">{{ $user->firstname }} {{ $user->lastname }}</h1>

        <table class="table w-auto">

            <tr>
                <td class="fw-bold text-end p-2">ID</td>
                <td class="p-2">{{$user->id}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Логин</td>
                <td class="p-2">{{$user->login}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Группа</td>
                <td class="p-2">{{ $group->title }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Почта</td>
                <td class="p-2">{{$user->email}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Активен</td>
                <td class="p-2">{{ $user->active ? "Да" : "Нет" }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Телефон</td>
                <td class="p-2">{{ $user->phone }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Telegram</td>
                <td class="p-2">{{ "@".$user->telegram_nickname }}</td>
            </tr>
        </table>

    </section>
@endsection
