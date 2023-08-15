@extends('layouts.main')

@section('page.title', ' - Опросы')

@section('main.content')

    <x-pageHeader>
        <x-buttons.plusLink route="{{ route('polls.create') }}">
            Создать новый опрос
        </x-buttons.plusLink>
    </x-pageHeader>

    @if($polls->isEmpty())
        <div> {{ __('Опросов пока нет') }} </div>
    @else

        <section class="polls mb-4">
            <table class="table align-middle">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center text-nowrap">Дата создания</th>
                    <th scope="col" class="text-center text-nowrap">Действителен до</th>
                    <th scope="col" class="text-center text-nowrap">Шаблон</th>
                    <th scope="col" class="text-center text-nowrap">Спот</th>
                    <th scope="col" class="text-center text-nowrap">Тайный гость</th>
                    <th scope="col" class="text-center text-nowrap">Статус</th>
                    <th scope="col" class="text-center text-nowrap">Действия</th>
                </tr>
                @foreach($polls as $poll)
                    <tr>
                        <th scope="row" class="text-center">{{ $poll->id }}</th>
                        <td class="text-center">{{ $poll->created_at->format('d.m.Y в H:i') }}</td>
                        <td class="text-center">{{ $poll->until_at->format('d.m.Y') }}</td>
                        <td class="text-center"><a target="_blank" href="{{ route('templates.show', $poll->template_id) }}">{{ $poll->template_title }}</a></td>
                        <td class="text-center"><a target="_blank" href="{{ route('spots.show', $poll->spot_id) }}">Surf Coffee® x {{ $poll->spot_title }} ({{ $poll->spot_city }})</a></td>
                        <td class="text-center"><a target="_blank" href="{{ route('guests.show', $poll->secret_guest_id) }}">{{ $poll->guest_name }} ({{ $poll->guest_city }})</a></td>
                        <td class="text-center">
                            @if(Carbon\Carbon::now() > $poll->until_at && $poll->closed != 1)
                                <p class="mb-0 text-warning fw-bold">просрочен</p>
                            @elseif($poll->closed == 1)
                                <p class="mb-0 text-danger fw-bold">закрыт</p>
                            @elseif(Carbon\Carbon::now() < $poll->until_at && $poll->closed == 0)
                                <p class="mb-0 text-success fw-bold">открыт</p>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank" href="{{ route("poll", encrypt_decrypt('encrypt', "{$poll->id}, {$poll->secret_guest_id}")) }}">
                                            <i class="me-2 bi bi-box-arrow-up-right"></i> Открыть опросник
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route("polls.show", $poll->id) }}">
                                            <i class="bi bi-info-circle me-2"></i> Посмотреть информацию
                                        </a>
                                    </li>
                                    @if(Carbon\Carbon::now() > $poll->until_at && $poll->closed != 1)
                                        <li>
                                            <a class="dropdown-item disabled">
                                                <i class="bi bi-x-circle me-2"></i> Закрыть опрос
                                            </a>
                                        </li>
                                        <li><h6 class="dropdown-header">Опрос просрочен, поэтому закрыть его нельзя</h6></li>
                                    @elseif($poll->closed == 1)
                                        <li>
                                            <a class="dropdown-item disabled">
                                                <i class="bi bi-x-circle me-2"></i> Закрыть опрос
                                            </a>
                                        </li>
                                        <li><h6 class="dropdown-header">Опрос закрыт {{ $poll->closed_at?->format("d.m.Y в H:i") }}</h6></li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" onclick="return confirm('Вы точно уверены, что хотите закрыть?')" href="{{ route("polls.close", $poll->id) }}">
                                                <i class="bi bi-x-circle me-2"></i> Закрыть опрос преждевременно
                                            </a>
                                        </li>
                                        <li><h6 class="dropdown-header">Открыть опрос заново не получится</h6></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>

        </section>

        {{ $polls->links() }}
    @endif
@endsection

