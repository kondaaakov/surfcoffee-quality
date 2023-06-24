@extends('layouts.main')

@section('page.title', " - Пользователь $user->login")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('users') }}" class="link">Назад</a>
    </x-pageHeader>

@endsection
