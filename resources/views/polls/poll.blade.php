@extends('layouts.poll')

@section('page.title', " - $title")

@section('content')
    <div class="container py-5 poll" style="max-width: 760px">
        <h1 class="poll-title text-center mb-5">{{ $title }}</h1>

        <form method="post" enctype="multipart/form-data" action="{{ route('poll.answer') }}">
            @csrf
            <input type="hidden" value="{{ $pollId }}" name="poll_id">

            <x-errors />

            @foreach($categories as $category)
                <section class="mb-5">
                    <h2 class="poll-section-title text-center">Раздел "{{ $category['title'] }}"</h2>

                    @if(isset($category['items']))
                        <div class="mb-4">
                            @foreach($category['items'] as $categoryLvl2)
                                <h3 class="poll-section-title text-center">{{ $categoryLvl2['title'] }}</h3>

                                @if(isset($categoryLvl2['items']))
                                    <div class="mb-3">
                                        @foreach($categoryLvl2['items'] as $categoryLvl3)
                                            <h4 class="poll-section-title text-center">{{ $categoryLvl3['title'] }}</h4>

                                            @if(isset($categoryLvl3['items']))
                                                <div class="mb-2">
                                                    @foreach($categoryLvl3['items'] as $categoryLvl4)
                                                        <h5 class="poll-section-title text-center">{{ $categoryLvl4['title'] }}</h5>

                                                        @if(isset($categoryLvl4['items']))
                                                            <div class="mb-2">
                                                                @foreach($categoryLvl4['items'] as $categoryLvl5)
                                                                    <div class="mb-2">
                                                                        <p class="poll-section-title text-center">{{ $categoryLvl5['title'] }}</p>

                                                                        <x-rates category="{{ $categoryLvl5['id'] }}" />
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        @else
                                                            <x-rates category="{{ $categoryLvl4['id'] }}" />
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <x-rates category="{{ $categoryLvl3['id'] }}" />
                                            @endif
                                        @endforeach
                                    </div>
                                    <hr>
                                @else
                                    <x-rates category="{{ $categoryLvl2['id'] }}" />
                                @endif
                            @endforeach
                        </div>
                    @else
                        <x-rates category="{{ $category['id'] }}" />
                    @endif
                </section>
            @endforeach

            <section class="mb-5">
                <h2 class="poll-section-title text-center mb-3">Фотография чека</h2>
                <div class="mb-3">
                    <input class="form-control @error('receipt') is-invalid @enderror" type="file" id="receipt" accept="image/*, image/heic" name="receipt">
                </div>
            </section>

            <div class="mb-5">
                <h2 class="poll-section-title text-center mb-3">Комментарий</h2>
                <div class="mb-3">
                    <textarea class="form-control" id="comment" name="comment" placeholder="Необязательно" rows="3">{{ old("comment") }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-100 btn btn-outline-dark">Отправить</button>
        </form>
    </div>
@endsection

