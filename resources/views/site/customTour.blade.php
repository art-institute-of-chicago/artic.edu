@extends('layouts.app')

@section('content')

    <h2 class="title f-module-title-2">{!! $custom_tour['title'] !!}</h2>
    <hr/>
    <div class="o-blocks">
        <p>ID: {{ $id }}</p>

        @if(array_key_exists('description', $custom_tour))
            <p>{{ $custom_tour['description'] }}</p>
        @endif

        <ul>
            @foreach ($custom_tour['artworks'] as $artwork)
                <li>
                    {{ $artwork['title'] }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection




