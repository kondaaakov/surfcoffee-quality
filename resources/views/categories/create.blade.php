@extends('layouts.forms')

@section('page.title', !empty($alternateTitle) ? "- $alternateTitle" : ' - Создание категории')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('categories') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="fw-light fs-2 text-center mb-4">{{ !empty($alternateTitle) ? $alternateTitle : __('Создание категории') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('categories.store') }}" class="form">
                @csrf

                <input type="hidden" name="include_in" value="{{ isset($_GET['include_in']) && $_GET['include_in'] != 0 ? $_GET['include_in'] : 0 }}">

                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Название') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title" id="title" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">{{ __('Вес категории') }}</label>
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" step="0.01" value="{{ old('weight') ?? 0 }}" name="weight" id="weight" autocomplete="off">
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Создать') }}</button>
            </form>

        </div>
    </div>

@endsection
