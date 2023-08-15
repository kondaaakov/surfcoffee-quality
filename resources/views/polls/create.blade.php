@extends('layouts.forms')

@section('page.title', ' - Создание опроса')

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            @if(isset($_GET['filter_id']))
                <x-pageHeader>
                    <a href="{{ route('templates').'#template_'.$_GET['filter_id'] }}" class="link">Назад к шаблонам</a>
                </x-pageHeader>
            @else
                <x-pageHeader>
                    <a href="{{ route('polls') }}" class="link">Назад к опросам</a>
                </x-pageHeader>
            @endif


            <h1 class="display-6 text-center mb-4">{{ __('Создание опроса') }}</h1>

            <x-errors />

            <form method="post" action="{{ route('polls.store') }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="template_id" class="form-label">{{ __('Шаблон') }}</label>
                    <select name="template_id" id="template_id" autocomplete="off">
                        <option value="" disabled>Выбрать шаблон</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ isset($_GET['filter_id']) && $_GET['filter_id'] == $template->id ? 'selected' : '' }}>{{ __($template->title) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="spot_id" class="form-label">{{ __('Спот') }}</label>
                    <select name="spot_id" id="spot_id" autocomplete="off">
                        <option value="" disabled>Выбрать спот</option>
                        @foreach($spots as $spot)
                            <option value="{{ $spot->id }}">{{ __("Surf Coffee® x $spot->title") }} (г. {{ $spot->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="secret_guest_id" class="form-label">{{ __('Тайный гость') }}</label>
                    <select name="secret_guest_id" id="secret_guest_id" autocomplete="off">
                        <option value="" disabled>Выбрать гостя</option>
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}">{{ $guest->name }} / {{ $guest->city }} / {{ "@$guest->telegram_nickname" }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="until_at" class="form-label">{{ __('Действителен до...') }}</label>
                    <input type="date" min="{{ $days }}" class="form-control @error('until_at') is-invalid @enderror" value="{{ old('until_at') ?? $days }}" name="until_at" id="until_at" autocomplete="off">
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Создать') }}</button>
            </form>

        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
@endpush

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>
@endpush
