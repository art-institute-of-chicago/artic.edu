@extends('layouts.app')

@section('content')

    <h1>Custom tour view - {{ $custom_tour['title'] }} </h1>

    <p>ID: {{ $id }}</p>

    <p>{{ $custom_tour['description'] }}</p>

    @foreach ($custom_tour['artworks'] as $artwork)
        <a href="{{ $artwork['url'] }}">{{ $artwork['title'] }}</a>
    @endforeach

@endsection




