@extends('layouts.app')

@section('content')

    <h1>Custom tour view - {{ $tour['title'] }} </h1>

    <p>ID: {{ $id }}</p>

    <p>{{ $tour['description'] }}</p>

    @foreach ($tour['artworks'] as $artwork)
        <a href="{{ $artwork['url'] }}">{{ $artwork['title'] }}</a>
    @endforeach

@endsection




