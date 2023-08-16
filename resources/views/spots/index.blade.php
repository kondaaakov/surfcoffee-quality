@extends('layouts.main')

@section('page.title', ' - Споты')

@section('main.content')

    <x-pageHeader>
        <x-buttons.plusLink route="{{ route('spots.create') }}">
            Добавить новый спот
        </x-buttons.plusLink>
    </x-pageHeader>

    @if($spots->isEmpty())
        <div> {{ __('Спотов не найдено') }} </div>
    @else



        <div class="row">
            @foreach($spots as $spot)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="spot card rounded-4 shadow-sm bg-light-subtle px-4 py-3">
                        <h5 class="card-title">{{ "Surf Coffee® x $spot->title" }} {{ $spot->active ? "" : "[Архив]" }}</h5>
                        <h6 class="card-subtitle mb-4 text-body-secondary">{{ "#$spot->external_id" }}, {{ "г. $spot->city" }}</h6>

                        <p class="mb-2 fs-5 fw-light">Средняя оценка: {!! $spot->rate('fs-5') !!}</p>

                        <div class="card-bottom d-flex justify-content-end align-items-center">
                            <a href="{{ route('spots.show', $spot->id) }}" class="card-link small">перейти</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{ $spots->links() }}
    @endif
@endsection
