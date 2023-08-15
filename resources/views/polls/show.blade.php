@extends('layouts.main')

@section('page.title', " - Опрос #$poll->id")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('polls') }}" class="link">Назад к опросам</a>
    </x-pageHeader>

    <section class="user">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="small text-muted mb-0"><b>Дата создания:</b> {{ $poll->created_at->format('d.m.Y в H:i') }}. <b>Дата истечения срока:</b> {{ $poll->until_at->format('d.m.Y') }}</p>
        </div>

        <h1 class="display-4 mb-4">Опрос #{{ $poll->id }}</h1>

        <table class="table w-auto mb-4">

            <tr>
                <td class="fw-bold text-end p-2">Шаблон</td>
                <td class="p-2"><a target="_blank" href="{{ route('templates.show', $poll->template_id) }}">{{ $poll->template_title }} <i class="ms-2 bi bi-box-arrow-up-right"></i></a></td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Спот</td>
                <td class="p-2"><a target="_blank" href="{{ route('spots.show', $poll->spot_id) }}">Surf Coffee® x {{ $poll->spot_title }} ({{ $poll->spot_city }}) <i class="ms-2 bi bi-box-arrow-up-right"></i></a></td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Тайный гость</td>
                <td class="p-2"><a target="_blank" href="{{ route('guests.show', $poll->secret_guest_id) }}">{{ $poll->guest_name }} ({{ $poll->guest_city }}) <i class="ms-2 bi bi-box-arrow-up-right"></i></a></td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Результат</td>
                <td class="p-2">{{ $poll->result ?? 0 }}</td>
            </tr>

            <tr>
                <td class="fw-bold text-end p-2">Статус</td>
                <td class="p-2">
                    @if(Carbon\Carbon::now() > $poll->until_at && $poll->closed != 1)
                        <p class="mb-0 text-warning fw-bold">просрочен</p>
                    @elseif($poll->closed == 1)
                        <p class="mb-0 text-danger fw-bold">закрыт {{ $poll->closed_at?->format("d.m.Y в H:i") }}</p>
                    @elseif(Carbon\Carbon::now() < $poll->until_at && $poll->closed == 0)
                        <p class="mb-0 text-success fw-bold">открыт</p>
                    @endif
                </td>
            </tr>
        </table>

        <section class="poll-categories">
            <div class="poll-categories-title mb-3 d-flex justify-content-between align-items-center">
                <h2>Категории</h2>
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    показать
                </a>
            </div>

            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <div class="d-flex justify-content-end">
                        <p class="badge text-bg-secondary">вес — оценка пользователя — результат</p>
                    </div>


                    <ol class="mb-0">
                        @foreach($categories as $categoryLvl1)
                            <li class="mb-2">
                                <div class="list-body d-flex align-items-center">
                                    <p class="mb-0 fw-semibold me-2">{{ $categoryLvl1['title'] }}</p>
                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl1['weight'] }} — {{ $categoryLvl1['rate'] }} — {{ $categoryLvl1['result'] }}</p>
                                </div>

                                @if(isset($categoryLvl1['items']))
                                    <ol>
                                        @foreach($categoryLvl1['items'] as $categoryLvl2)
                                            <li class="mb-1">
                                                <div class="list-body d-flex align-items-center">
                                                    <p class="mb-0 me-2">{{ $categoryLvl2['title'] }}</p>
                                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl2['weight'] }} — {{ $categoryLvl2['rate'] }} — {{ $categoryLvl2['result'] }}</p>
                                                </div>

                                                @if(isset($categoryLvl2['items']))
                                                    <ol>
                                                        @foreach($categoryLvl2['items'] as $categoryLvl3)
                                                            <li class="mb-1">
                                                                <div class="list-body d-flex align-items-center">
                                                                    <p class="mb-0 me-2">{{ $categoryLvl3['title'] }}</p>
                                                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl3['weight'] }} — {{ $categoryLvl3['rate'] }} — {{ $categoryLvl3['result'] }}</p>
                                                                </div>

                                                                @if(isset($categoryLvl3['items']))
                                                                    <ol>
                                                                        @foreach($categoryLvl3['items'] as $categoryLvl4)
                                                                            <li class="mb-1">
                                                                                <div class="list-body d-flex align-items-center">
                                                                                    <p class="mb-0 me-2">{{ $categoryLvl4['title'] }}</p>
                                                                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl4['weight'] }} — {{ $categoryLvl4['rate'] }} — {{ $categoryLvl4['result'] }}</p>
                                                                                </div>

                                                                                @if(isset($categoryLvl4['items']))
                                                                                    <ol>
                                                                                        @foreach($categoryLvl4['items'] as $categoryLvl5)
                                                                                            <li class="mb-1">
                                                                                                <div class="list-body d-flex align-items-center">
                                                                                                    <p class="mb-0 me-2">{{ $categoryLvl5['title'] }}</p>
                                                                                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl5['weight'] }} — {{ $categoryLvl5['rate'] }} — {{ $categoryLvl5['result'] }}</p>
                                                                                                </div>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ol>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach

                    </ol>
                </div>
            </div>
        </section>

    </section>
@endsection
