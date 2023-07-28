@extends('layouts.forms')

@section('page.title', " - Редактирование Surf Coffee® x $spot->title")

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('spots.show', $spot->id) }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">{{ __("Редактирование") . " Surf Coffee® x $spot->title" }}</h1>

            <x-errors />

            <form method="post" action="{{ route('spots.update', $spot->id) }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="external_id" class="form-label">{{ __('Внешний идентификатор (из Bitrix24)') }}</label>
                    <input type="text" class="form-control @error('external_id') is-invalid @enderror" value="{{ $spot->external_id ?? "" }}" name="external_id" id="external_id" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Наименование спота') }}</label>

                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon">Surf Coffee® x</span>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $spot->title ?? '' }}" name="title" id="title" autocomplete="off">
                    </div>

                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">{{ __('Город') }}</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" value="{{ $spot->city ?? '' }}" name="city" id="city" autocomplete="off">
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">{{ __('Статус') }}</label>
                    <select class="form-select" name="status" id="status" autocomplete="off">
                        <option selected disabled>Выбрать статус</option>
                        @foreach($statuses as $key => $status)
                            <option {{ $spot->status == $key ? "selected" : '' }} value="{{ $key }}">{{ __($status) }}</option>
                        @endforeach

                    </select>
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Сохранить') }}</button>
            </form>

        </div>
    </div>

@endsection
