@extends('layouts.app')

@section('content')

    <h2 class="title f-module-title-2">{{ $custom_tour['title'] }} </h2>
    <hr/>
    <div class="o-blocks">
        <p>ID: {{ $id }}</p>

    <p>ID: {{ $id }}</p>

    <p>{{ $custom_tour['description'] }}</p>

    @foreach ($custom_tour['artworks'] as $artwork)
        <div>
            <a href="{{ $artwork['url'] }}">{{ $artwork['title'] }}</a>

            @if (array_key_exists('objectNote', $artwork))
                <p>{{ $artwork['objectNote'] }}</p>
            @endif
        </div>
    @endforeach

        <ul>
            @foreach ($custom_tour['artworks'] as $artwork)
                <li>
                    {{ $artwork['title'] }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection




