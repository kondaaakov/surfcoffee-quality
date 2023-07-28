@extends('layouts.main')

@section('page.title', ' - Категории')

@section('main.content')

    @if(empty($categories))
        <div class="mb-3"> {{ __('Категорий не найдено') }} </div>

        <a href="{{ route("categories.create") }}" class="bg-light-subtle shadow-sm text-center p-3 rounded-4 border d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Добавить категорию
        </a>
    @else

        @foreach($categories as $categoryLvl1)
            <section style="border-top: 1px solid #e8e8e8; border-left: 1px solid #e8e8e8" class="mb-5 ps-2 pt-2">
                <p style="color: #e8e8e8; font-size: 0.6rem;" class="mb-1 text-uppercase fw-bold">LVL 1</p>
                <div id="{{ $categoryLvl1['id'] }}" class="bg-light shadow-sm p-3 rounded-4 border d-flex justify-content-between align-items-center mb-4">
                    <h1 style="font-size: 3rem;" class="fw-light mb-0 {{ $categoryLvl1['active'] == 0 ? "text-decoration-line-through" : '' }}">{{ $categoryLvl1['title'] }}</h1>

                    <div class="cat-side d-flex align-items-center">
                        @if($categoryLvl1['weight'] > 0)
                            <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl1['weight'] }}</p>
                        @endif

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route("categories.edit", $categoryLvl1['id']) }}"><i class="bi bi-pencil-square me-2"></i> Редактировать</a></li>
                                <li><a class="dropdown-item" href="{{ route("categories.create", ['include_in' => $categoryLvl1['id']]) }}"><i class="bi bi-plus-circle-fill me-2"></i> Добавить подкатегорию</a></li>

                                @if($categoryLvl1['active'] == 1)
                                    <li><a class="dropdown-item" onclick="return confirm('Архивировать категорию {{ $categoryLvl1['title'] }}? Все подкатегории ниже будут также архивированы!')" href="{{ route("categories.archive", $categoryLvl1['id']) }}"><i class="bi bi-archive-fill me-2"></i> Архивировать</a></li>
                                @else
                                    <li><a class="dropdown-item" onclick="return confirm('Разархивировать категорию {{ $categoryLvl1['title'] }}? Все подкатегории также будут разархивированы.')" href="{{ route("categories.unarchive", $categoryLvl1['id']) }}"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                @if(isset($categoryLvl1['items']))
                    @foreach($categoryLvl1['items'] as $categoryLvl2)
                        <section style="padding-left: 2rem;" class="mb-4">
                            <p style="color: #e8e8e8; font-size: 0.6rem;" class="mb-1 text-uppercase fw-bold">LVL 2</p>
                            <div id="{{ $categoryLvl2['id'] }}" class="bg-light shadow-sm p-3 rounded-4 border d-flex justify-content-between align-items-center mb-3">
                                <h1 style="font-size: 2.5rem;" class="fw-light mb-0 {{ $categoryLvl2['active'] == 0 ? "text-decoration-line-through" : '' }}">{{ $categoryLvl2['title'] }}</h1>

                                <div class="cat-side d-flex align-items-center">
                                    @if($categoryLvl2['weight'] > 0)
                                        <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl2['weight'] }}</p>
                                    @endif

                                    <div class="btn-group btn-group-sm ms-3" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route("categories.edit", $categoryLvl2['id']) }}"><i class="bi bi-pencil-square me-2"></i> Редактировать</a></li>
                                            <li><a class="dropdown-item" href="{{ route("categories.create", ['include_in' => $categoryLvl2['id']]) }}"><i class="bi bi-plus-circle-fill me-2"></i> Добавить подкатегорию</a></li>

                                            @if($categoryLvl2['active'] == 1)
                                                <li><a class="dropdown-item" onclick="return confirm('Архивировать категорию {{ $categoryLvl2['title'] }}?')" href="{{ route("categories.archive", $categoryLvl2['id']) }}"><i class="bi bi-archive-fill me-2"></i> Архивировать</a></li>
                                            @elseif($categoryLvl2['active'] == 0 && $categoryLvl2['parent']['active'] == 0)
                                                <li><a class="dropdown-item disabled" href="#"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                <li><h6 class="dropdown-header">Разархивируйте сначала категорию уровня выше</h6></li>
                                            @else
                                                <li><a class="dropdown-item" onclick="return confirm('Разархивировать категорию {{ $categoryLvl2['title'] }}? Все подкатегории также будут разархивированы.')" href="{{ route("categories.unarchive", $categoryLvl2['id']) }}"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @if(isset($categoryLvl2['items']))
                                @foreach($categoryLvl2['items'] as $categoryLvl3)
                                    <section style="padding-left: 2rem;" class="mb-4">
                                        <p style="color: #e8e8e8; font-size: 0.6rem;" class="mb-1 text-uppercase fw-bold">LVL 3</p>
                                        <div id="{{ $categoryLvl3['id'] }}" class="bg-light shadow-sm p-3 rounded-4 border d-flex justify-content-between align-items-center mb-3">
                                            <h1 style="font-size: 2rem;" class="fw-light mb-0 {{ $categoryLvl3['active'] == 0 ? "text-decoration-line-through" : '' }}">{{ $categoryLvl3['title'] }}</h1>

                                            <div class="cat-side d-flex align-items-center">
                                                @if($categoryLvl3['weight'] > 0)
                                                    <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl3['weight'] }}</p>
                                                @endif

                                                <div class="btn-group btn-group-sm ms-3" role="group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route("categories.edit", $categoryLvl3['id']) }}"><i class="bi bi-pencil-square me-2"></i> Редактировать</a></li>
                                                        <li><a class="dropdown-item" href="{{ route("categories.create", ['include_in' => $categoryLvl3['id']]) }}"><i class="bi bi-plus-circle-fill me-2"></i> Добавить подкатегорию</a></li>
                                                        @if($categoryLvl3['active'] == 1)
                                                            <li><a class="dropdown-item" onclick="return confirm('Архивировать категорию {{ $categoryLvl3['title'] }}?')" href="{{ route("categories.archive", $categoryLvl3['id']) }}"><i class="bi bi-archive-fill me-2"></i> Архивировать</a></li>
                                                        @elseif($categoryLvl3['active'] == 0 && $categoryLvl3['parent']['active'] == 0)
                                                            <li><a class="dropdown-item disabled" href="#"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                            <li><h6 class="dropdown-header">Разархивируйте сначала категорию уровня выше</h6></li>
                                                        @else
                                                            <li><a class="dropdown-item" onclick="return confirm('Разархивировать категорию {{ $categoryLvl3['title'] }}? Все подкатегории также будут разархивированы.')" href="{{ route("categories.unarchive", $categoryLvl3['id']) }}"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        @if(isset($categoryLvl3['items']))
                                            @foreach($categoryLvl3['items'] as $categoryLvl4)
                                                <section style="padding-left: 3rem;" class="mb-3">
                                                    <p style="color: #e8e8e8; font-size: 0.6rem;" class="mb-1 text-uppercase fw-bold">LVL 4</p>
                                                    <div id="{{ $categoryLvl4['id'] }}" class="bg-light shadow-sm p-3 rounded-4 border d-flex justify-content-between align-items-center mb-2">
                                                        <h1 style="font-size: 1.5rem;" class="fw-light mb-0 {{ $categoryLvl4['active'] == 0 ? "text-decoration-line-through" : '' }}">{{ $categoryLvl4['title'] }}</h1>

                                                        <div class="cat-side d-flex align-items-center">
                                                            @if($categoryLvl4['weight'] > 0)
                                                                <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl4['weight'] }}</p>
                                                            @endif

                                                            <div class="btn-group btn-group-sm ms-3" role="group">
                                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-three-dots"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="{{ route("categories.edit", $categoryLvl4['id']) }}"><i class="bi bi-pencil-square me-2"></i> Редактировать</a></li>
                                                                    <li><a class="dropdown-item" href="{{ route("categories.create", ['include_in' => $categoryLvl4['id']]) }}"><i class="bi bi-plus-circle-fill me-2"></i> Добавить подкатегорию</a></li>
                                                                    @if($categoryLvl4['active'] == 1)
                                                                        <li><a class="dropdown-item" onclick="return confirm('Архивировать категорию {{ $categoryLvl4['title'] }}?')" href="{{ route("categories.archive", $categoryLvl4['id']) }}"><i class="bi bi-archive-fill me-2"></i> Архивировать</a></li>
                                                                    @elseif($categoryLvl4['active'] == 0 && $categoryLvl4['parent']['active'] == 0)
                                                                        <li><a class="dropdown-item disabled" href="#"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                                        <li><h6 class="dropdown-header">Разархивируйте сначала категорию уровня выше</h6></li>
                                                                    @else
                                                                        <li><a class="dropdown-item" onclick="return confirm('Разархивировать категорию {{ $categoryLvl4['title'] }}? Все подкатегории также будут разархивированы.')" href="{{ route("categories.unarchive", $categoryLvl4['id']) }}"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(isset($categoryLvl4['items']))
                                                        @foreach($categoryLvl4['items'] as $categoryLvl5)
                                                            <section style="padding-left: 4rem;" class="mb-2">
                                                                <p style="color: #e8e8e8; font-size: 0.6rem;" class="mb-1 text-uppercase fw-bold">LVL 5</p>
                                                                <div id="{{ $categoryLvl5['id'] }}" class="bg-light shadow-sm p-3 rounded-4 border d-flex justify-content-between align-items-center mb-1">
                                                                    <h1 style="font-size: 1rem;" class="fw-light mb-0 {{ $categoryLvl5['active'] == 0 ? "text-decoration-line-through" : '' }}">{{ $categoryLvl5['title'] }}</h1>

                                                                    <div class="cat-side d-flex align-items-center">
                                                                        @if($categoryLvl5['weight'] > 0)
                                                                            <p class="mb-0 badge text-bg-secondary">{{ $categoryLvl5['weight'] }}</p>
                                                                        @endif

                                                                        <div class="btn-group btn-group-sm ms-3" role="group">
                                                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="bi bi-three-dots"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a class="dropdown-item" href="{{ route("categories.edit", $categoryLvl5['id']) }}"><i class="bi bi-pencil-square me-2"></i> Редактировать</a></li>
                                                                                <li><a class="dropdown-item disabled" href="#"><i class="bi bi-plus-circle-fill me-2"></i> Добавить подкатегорию</a></li>
                                                                                <li><h6 class="dropdown-header">Достигнуто максимум уровней: 5</h6></li>
                                                                                @if($categoryLvl5['active'] == 1)
                                                                                    <li><a class="dropdown-item" onclick="return confirm('Архивировать категорию {{ $categoryLvl5['title'] }}?')" href="{{ route("categories.archive", $categoryLvl5['id']) }}"><i class="bi bi-archive-fill me-2"></i> Архивировать</a></li>
                                                                                @elseif($categoryLvl5['active'] == 0 && $categoryLvl5['parent']['active'] == 0)
                                                                                    <li><a class="dropdown-item disabled" href="#"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                                                    <li><h6 class="dropdown-header">Разархивируйте сначала категорию уровня выше</h6></li>
                                                                                @else
                                                                                    <li><a class="dropdown-item" onclick="return confirm('Разархивировать категорию {{ $categoryLvl5['title'] }}?')" href="{{ route("categories.unarchive", $categoryLvl5['id']) }}"><i class="bi bi-archive-fill me-2"></i> Разархивировать</a></li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        @endforeach
                                                    @endif
                                                </section>
                                            @endforeach
                                        @endif
                                    </section>
                                @endforeach
                            @endif
                        </section>
                    @endforeach
                @endif
            </section>
        @endforeach

        <a href="{{ route("categories.create") }}" class="bg-light-subtle shadow-sm text-center p-3 rounded-4 border d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Добавить категорию
        </a>

    @endif
@endsection
