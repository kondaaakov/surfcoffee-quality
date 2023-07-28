@extends('layouts.forms')

@section('page.title', ' - Создание секретного гостя')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('guests') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">{{ __('Создание гостя') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('guests.store') }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Имя') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="name" autocomplete="off" autofocus>
                </div>

                <div class="mb-3">
                    <label for="telegram_nickname" class="form-label">{{ __('Никнейм в телеграме') }}</label>

                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon">@</span>
                        <input type="text" class="form-control @error('telegram_nickname') is-invalid @enderror" value="{{ old('telegram_nickname') }}" name="telegram_nickname" id="telegram_nickname" autocomplete="off">
                    </div>

                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Телефон') }}</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone" id="phone" autocomplete="off">
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">{{ __('Город') }}</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" name="city" id="city" autocomplete="off">
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">{{ __('Статус') }}</label>
                    <select class="form-select" name="status" id="status" autocomplete="off">
                        <option selected disabled>Выбрать статус</option>
                        @foreach($statuses as $key => $status)
                            <option value="{{ $key }}">{{ __($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Создать') }}</button>
            </form>

        </div>
    </div>

@endsection
