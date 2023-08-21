@extends('layouts.main')

@section('page.title', " - Surf Coffee® x $spot->title")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('spots') }}" class="link">Назад</a>
    </x-pageHeader>

    <section class="spot">
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

        <table class="table w-auto mb-5">

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

        <div class="reviews">
            <h3 class="display-6 mb-4">Проверки</h3>

            @if(!$polls->isEmpty())
                <table class="table table-striped table-hover align-middle w-auto">
                    <thead>
                    <tr>
                        <th class="" scope="col">#</th>
                        <th class="px-2 text-center" scope="col">Дата проверки</th>
                        <th class="px-2 text-center" scope="col">Гость</th>
                        <th class="px-2 text-center" scope="col">Результат</th>
                        <th class="px-2 text-center" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($polls as $poll)
                        <tr>
                            <th class="" scope="row">{{ $poll->id }}</th>
                            <td class="px-3 text-center" >{{ $poll->closed_at?->format("Y.m.d в H:i") }}</td>
                            <td class="px-3 text-center" ><a target="_blank" href="{{ route('guests.show', $poll->secret_guest_id) }}">{{ $poll->guest_name }} ({{ $poll->guest_city }}) <i class="ms-2 bi bi-box-arrow-up-right"></i></a></td>
                            <td class="px-3 text-center" >{!! coloredRate($poll->result) !!}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route("polls.show", $poll->id) }}">
                                                <i class="bi bi-info-circle me-2"></i> Посмотреть информацию
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>По данному споту пока не было проверок</p>
            @endif

        </div>
    </section>
@endsection
