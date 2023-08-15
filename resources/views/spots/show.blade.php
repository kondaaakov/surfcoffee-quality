@extends('layouts.main')

@section('page.title', " - Surf Coffee® x $spot->title")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('spots') }}" class="link">Назад</a>
    </x-pageHeader>

    <section class="user">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">
                <a href="{{ route("spots.edit", $spot->id) }}" class="link me-2">Редактировать</a>
                @if($spot->active === 1)
                    <a href="{{ route("spots.archive", $spot->id) }}" onclick="return confirm('Архивировать спот Surf Coffee® x {{ $spot->title }}?')" class="link text-warning">Архивировать</a>
                @else
                    <a href="{{ route("spots.unarchive", $spot->id) }}" onclick="return confirm('Разархивировать спот Surf Coffee® x {{ $spot->title }}?')" class="link text-warning">Разархивировать</a>
                @endif

            </p>

            <p class="small text-muted mb-0"><b>Дата создания:</b> {{ $spot->created_at->format('d.m.Y H:i') }}. <b>Дата изменения:</b> {{ $spot->updated_at->format('d.m.Y H:i') }}</p>
        </div>

        <h1 class="display-4 mb-4">Surf Coffee® x {{ $spot->title }}</h1>

        <table class="table w-auto">

            <tr>
                <td class="fw-bold text-end p-2">Внешний идентификатор<br>(из Битрикс24)</td>
                <td class="p-2">{{$spot->external_id}}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Город</td>
                <td class="p-2">{{ $spot->city }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Статус</td>
                <td class="p-2">{{ $statuses[$spot->status] }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Средняя оценка</td>
                <td class="p-2">{!! $spot->rate() !!}</td>
            </tr>
        </table>

    </section>
@endsection
