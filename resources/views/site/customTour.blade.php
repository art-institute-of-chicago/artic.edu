@extends('layouts.app')

@section('content')

    <h2 class="title f-module-title-2">{{ $custom_tour['title'] }} </h2>
    <hr/>
    <div class="o-blocks">
        <p>ID: {{ $id }}</p>

        <p>{{ $custom_tour['description'] }}</p>
        
        <ul>
            @foreach ($custom_tour['artworks'] as $artwork)
                <li>
                    {{ $artwork['title'] }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection




