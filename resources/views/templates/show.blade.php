@extends('layouts.main')

@section('page.title', " - Шаблон $template->title")

@section('main.content')

    <x-pageHeader>
        <a href="{{ route('templates') }}" class="link">Назад</a>
    </x-pageHeader>

    <section class="user">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">
                <a href="{{ route("templates.edit", $template->id) }}" class="link me-2">Редактировать</a>
            </p>

            <p class="small text-muted mb-0"><b>Дата создания:</b> {{ $template->created_at->format('d.m.Y H:i') }}. <b>Дата изменения:</b> {{ $template->updated_at->format('d.m.Y H:i') }}</p>
        </div>

        <h1 class="display-4 mb-4">Шаблон {{ $template->title }}</h1>

        @if(!empty($categories))
            <section class="categories">
                <h1 class="fs-3 fw-light">Категории</h1>

                <ol class="categories-lvls">
                    @foreach($categories as $categoryLvl1)
                        <li>
                            {{ $categoryLvl1['title'] }}

                            @if(!empty($categoryLvl1['items']))
                                <ul class="categories-lvl2">
                                    @foreach($categoryLvl1['items'] as $categoryLvl2)
                                        <li>
                                            {{ $categoryLvl2['title'] }}

                                            @if(!empty($categoryLvl2['items']))
                                                <ul class="categories-lvl2">
                                                    @foreach($categoryLvl2['items'] as $categoryLvl3)
                                                        <li>
                                                            {{ $categoryLvl3['title'] }}

                                                            @if(!empty($categoryLvl3['items']))
                                                                <ul class="categories-lvl2">
                                                                    @foreach($categoryLvl3['items'] as $categoryLvl4)
                                                                        <li>
                                                                            {{ $categoryLvl4['title'] }}

                                                                            @if(!empty($categoryLvl4['items']))
                                                                                <ul class="categories-lvl2">
                                                                                    @foreach($categoryLvl4['items'] as $categoryLvl5)
                                                                                        <li>
                                                                                            {{ $categoryLvl5['title'] }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ol>

                <section class="categories-lvls">
                    @foreach($categories as $categoryLvl1)
                        <div class="categories-lvl1 mb-2">

                        </div>
                    @endforeach
                </section>
            </section>
        @endif

    </section>
@endsection
