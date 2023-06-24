@extends('layouts.main')

@section('page.title', ' - Пользователи')

@section('main.content')

    <x-pageHeader>
        <x-buttons.plusLink route="{{ route('users.create') }}">
            Добавить
        </x-buttons.plusLink>
    </x-pageHeader>

    @if(empty($users))
        <div> {{ __('Записей не найдено') }} </div>
    @else

        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Логин</th>
                <th scope="col">Почта</th>
                <th scope="col">Группа</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->title }}</td>
                    <td>
                        <x-buttons.actions
                            show="{{route('users.show', $user->id)}}"
                            edit="{{route('users.edit', $user->id)}}"
                            delete="{{route('users.delete', $user->id)}}"
                        />
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        {{ $users->links() }}
    @endif
@endsection
