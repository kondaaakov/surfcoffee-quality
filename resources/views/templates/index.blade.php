@extends('layouts.main')

@section('page.title', ' - Шаблоны')

@section('main.content')

    <x-pageHeader>
        <x-buttons.plusLink route="{{ route('templates.create') }}">
            Создать новый шаблон
        </x-buttons.plusLink>
    </x-pageHeader>

    @if($templates->isEmpty())
        <div> {{ __('Шаблонов пока нет') }} </div>
    @else

        <section class="templates mb-4">
            <table class="table align-middle">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Название</th>
                    <th scope="col" class="text-center">Дата создания</th>
                    <th scope="col" class="text-center">Разделы категорий</th>
                    <th scope="col" class="text-center">Опросы</th>
                    <th scope="col" class="text-center">Действия</th>
                </tr>
                @foreach($templates as $template)
                    <tr id="template_{{ $template->id }}">
                        <th scope="row" class="text-center">{{ $template->id }}</th>
                        <td class="text-center">{{ $template->title }}</td>
                        <td class="text-center">{{ $template->created_at->format('d.m.Y в H:i') }}</td>
                        <td class="text-center">{{ count(unserialize($template->categories)) }} шт.</td>
                        <td class="text-center">
                            @if(isset($pollsCount[$template->id]))
                                <p class="mb-0">Опросов: <a class="d-inline-flex align-items-center" href="{{ route('polls', ['filter_id' => $template->id]) }}">{{ $pollsCount[$template->id] }} шт.</a></p>
                            @endif
                            <a href="{{ route('polls.create', ['filter_id' => $template->id]) }}">Создать опрос</a>
                        </td>
                        <td class="text-center">
                            <x-buttons.actions
                                show="{{route('templates.show', $template->id)}}"
                                edit="{{route('templates.edit', $template->id)}}"
                                archive="{{route('templates.archive', $template->id)}}"
                            />
                        </td>
                    </tr>
                @endforeach
            </table>

        </section>

        {{ $templates->links() }}
    @endif
@endsection

