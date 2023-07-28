@extends('layouts.forms')

@section('page.title', " - Редактирование категории \"$category->title\"")

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('categories') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">{{ __('Редактирование категории') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('categories.update', $category->id) }}" class="form">
                @csrf

                <input type="hidden" name="include_in" value="{{ $category->include_in ?? 0 }}">

                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Название') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $category->title ?? "" }}" name="title" id="title" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">{{ __('Вес категории') }}</label>
                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" value="{{ $category->weight ?? '' }}" name="weight" id="weight" autocomplete="off">
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Сохранить') }}</button>
            </form>

        </div>
    </div>

@endsection
