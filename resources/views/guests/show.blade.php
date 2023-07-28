@extends('layouts.main')

@section('page.title', " - Тайный гость $entity->name")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('guests') }}" class="link">Назад</a>
    </x-pageHeader>

    <section class="user">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">
                <a href="{{ route("guests.edit", $entity->id) }}" class="link me-2">Редактировать</a>
                <a href="{{ route("guests.delete", $entity->id) }}" onclick="return confirm('Удалить тайного гостя {{ $entity->name }}?')" class="link text-danger">Удалить</a>
            </p>

            <p class="small text-muted mb-0"><b>Дата создания:</b> {{ $entity->created_at->format('d.m.Y H:i') }}. <b>Дата изменения:</b> {{ $entity->updated_at->format('d.m.Y H:i') }}</p>
        </div>

        <h1 class="display-4 mb-4">{{ $entity->name }}</h1>

        <table class="table w-auto">

            <tr>
                <td class="fw-bold text-end p-2">ID</td>
                <td class="p-2">{{$entity->id}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Статус</td>
                <td class="p-2">{{ $statuses[$entity->status] }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Город</td>
                <td class="p-2">{{$entity->city}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Телефон</td>
                <td class="p-2">{{ $entity->phone }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Telegram</td>
                <td class="p-2"><a target="_blank" href="{{ 'https://t.me/' . $entity->telegram_nickname }}">{{ '@' . $entity->telegram_nickname }}</a></td>
            </tr>
        </table>

    </section>
@endsection
