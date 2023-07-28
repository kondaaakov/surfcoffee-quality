@extends('layouts.forms')

@section('page.title', " - Редактирование шаблона {$template->title}")

@section('forms.content')
    <div class="row justify-content-center">
        <div class="bg-white col-xl-5 col-lg-6 col-md-8 col-sm-10 rounded-4 p-4">

            <x-pageHeader>
                <a href="{{ route('templates') }}" class="link">Назад</a>
            </x-pageHeader>

            <h1 class="display-6 text-center mb-4">Редактирование шаблона {{$template->title}}</h1>

            <x-errors />

            <form method="post" action="{{ route('templates.update', $template->id) }}" class="form">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Название шаблона') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $template->title ?? '' }}" name="title" id="title" autocomplete="off">
                </div>

                <div class="mb-3">
                    <h4 style="font-size: 1.6rem;" class="fw-light mb-3 text-center">Категории</h4>
                    <p onclick="toggle(this)" class="toggle-checkboxes toggle-add mb-3">Выбрать всё</p>
                    @if(!empty($categories))
                        @foreach($categories as $categoryLvl1)
                            <div style="margin-bottom: 1rem; border-left: 1px solid #ededed; padding-left: 0.5rem;" class="cat">
                                <div class="form-check d-flex">
                                    <input class="form-check-input" type="checkbox" value="1" {{ in_array($categoryLvl1['id'], $categoriesInTemplate) ? 'checked' : '' }} name="{{ "cat_{$categoryLvl1['id']}" }}" id="{{ "cat_{$categoryLvl1['id']}" }}">
                                    <label class="form-check-label w-100 ms-2" for="{{ "cat_{$categoryLvl1['id']}" }}">
                                        {{ $categoryLvl1['title'] }}
                                    </label>
                                </div>

                                @if(isset($categoryLvl1['items']))
                                    @foreach($categoryLvl1['items'] as $categoryLvl2)
                                        <div style="padding-left: 1rem;" class="cat">
                                            <div class="form-check d-flex">
                                                <input class="form-check-input" type="checkbox" value="1" {{ in_array($categoryLvl2['id'], $categoriesInTemplate) ? 'checked' : '' }} name="{{ "cat_{$categoryLvl2['id']}" }}" id="{{ "cat_{$categoryLvl2['id']}" }}">
                                                <label class="form-check-label w-100 ms-2" for="{{ "cat_{$categoryLvl2['id']}" }}">
                                                    {{ $categoryLvl2['title'] }} <sup style="font-size: 0.6rem;" class="badge text-bg-secondary">{{ $categoryLvl2['weight'] }}</sup>
                                                </label>
                                            </div>

                                            @if(isset($categoryLvl2['items']))
                                                @foreach($categoryLvl2['items'] as $categoryLvl3)
                                                    <div style="padding-left: 2rem;" class="cat">
                                                        <div class="form-check d-flex">
                                                            <input class="form-check-input" type="checkbox" value="1" {{ in_array($categoryLvl3['id'], $categoriesInTemplate) ? 'checked' : '' }} name="{{ "cat_{$categoryLvl3['id']}" }}" id="{{ "cat_{$categoryLvl3['id']}" }}">
                                                            <label class="form-check-label w-100 ms-2" for="{{ "cat_{$categoryLvl3['id']}" }}">
                                                                {{ $categoryLvl3['title'] }} <sup style="font-size: 0.6rem;" class="badge text-bg-secondary">{{ $categoryLvl3['weight'] }}</sup>
                                                            </label>
                                                        </div>

                                                        @if(isset($categoryLvl3['items']))
                                                            @foreach($categoryLvl3['items'] as $categoryLvl4)
                                                                <div style="padding-left: 3rem;" class="cat">
                                                                    <div class="form-check d-flex">
                                                                        <input class="form-check-input" type="checkbox" value="1" {{ in_array($categoryLvl4['id'], $categoriesInTemplate) ? 'checked' : '' }} name="{{ "cat_{$categoryLvl4['id']}" }}" id="{{ "cat_{$categoryLvl4['id']}" }}">
                                                                        <label class="form-check-label w-100 ms-2" for="{{ "cat_{$categoryLvl4['id']}" }}">
                                                                            {{ $categoryLvl4['title'] }}  <sup style="font-size: 0.6rem;" class="badge text-bg-secondary">{{ $categoryLvl4['weight'] }}</sup>
                                                                        </label>
                                                                    </div>

                                                                    @if(isset($categoryLvl4['items']))
                                                                        @foreach($categoryLvl4['items'] as $categoryLvl5)
                                                                            <div style="padding-left: 4rem;" class="cat">
                                                                                <div class="form-check d-flex">
                                                                                    <input class="form-check-input" type="checkbox" value="1" {{ in_array($categoryLvl5['id'], $categoriesInTemplate) ? 'checked' : '' }} name="{{ "cat_{$categoryLvl5['id']}" }}" id="{{ "cat_{$categoryLvl5['id']}" }}">
                                                                                    <label class="form-check-label w-100 ms-2" for="{{ "cat_{$categoryLvl5['id']}" }}">
                                                                                        {{ $categoryLvl5['title'] }} <sup style="font-size: 0.6rem;" class="badge text-bg-secondary">{{ $categoryLvl5['weight'] }}</sup>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>

                <button class="btn btn-primary w-100" type="submit">{{ __('Сохранить') }}</button>
            </form>

        </div>
    </div>

@endsection

@push('js')
    <script>
        function toggle(source) {
            source.attributes.onclick.nodeValue = 'cancel(this)';
            source.classList.remove("toggle-add");
            source.classList.add("toggle-remove");
            source.textContent = "Отменить всё";

            const checkboxes = document.getElementsByClassName('form-check-input');
            for(let i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = true;
            }
        }

        function cancel(source) {
            source.attributes.onclick.nodeValue = 'toggle(this)';
            source.classList.remove("toggle-remove");
            source.classList.add("toggle-add");
            source.textContent = "Выбрать всё";

            const checkboxes = document.getElementsByClassName('form-check-input');
            for(let i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = false;
            }
        }
    </script>
@endpush
