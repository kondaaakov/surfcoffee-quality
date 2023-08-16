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

        <table class="table w-auto mb-5">

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

        <div class="reviews">
            <h3 class="display-6">Проверки</h3>

            @if(!empty($polls))
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
                            <td class="px-3 text-center" ><a target="_blank" href="{{ route('spots.show', $poll->spot_id) }}">{{ $poll->spot_title }} ({{ $poll->spot_city }}) <i class="ms-2 bi bi-box-arrow-up-right"></i></a></td>
                            <td class="px-3 text-center" >{!! coloredRate($poll->result ?? 0) !!}</td>
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
                <p>На данного секретного гостя пока не было назначено проверок</p>
            @endif

        </div>

    </section>
@endsection
