@extends('layouts.main')

@section('page.title', ' - Секретные гости')

@section('main.content')

    <x-pageHeader>
        <x-buttons.plusLink route="{{ route('guests.create') }}">
            Добавить
        </x-buttons.plusLink>
    </x-pageHeader>

    @if($guests->isEmpty())
        <div> {{ __('Записей не найдено') }} </div>
    @else

        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">Дата создания</th>
                <th scope="col">Имя</th>
                <th scope="col">Телеграм</th>
                <th scope="col">Телефон</th>
                <th scope="col">Город</th>
                <th scope="col">Статус</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($guests as $guest)
                <tr>
                    <th class="text-center" scope="row">{{ $guest->id }}</th>
                    <td class="text-center">{{ $guest->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $guest->name }}</td>
                    <td><a target="_blank" href="{{ 'https://t.me/' . $guest->telegram_nickname }}">{{ '@' . $guest->telegram_nickname }}</a></td>
                    <td>{{ $guest->phone }}</td>
                    <td>{{ $guest->city }}</td>
                    <td>{{ $statuses[$guest->status] }}</td>
                    <td>
                        <x-buttons.actions
                            show="{{route('guests.show', $guest->id)}}"
                            edit="{{route('guests.edit', $guest->id)}}"
                            delete="{{route('guests.delete', $guest->id)}}"
                        />
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        {{ $guests->links() }}
    @endif
@endsection
