@extends('layouts.app')

@section('content')

    <h2 class="title f-module-title-2">{!! $custom_tour['title'] !!}</h2>
    <hr/>
    <div class="o-blocks">
        <p>ID: {{ $id }}</p>

        @isset($custom_tour['creatorName'])
            <p id="creatorName">Tour made by {{ $custom_tour['creatorName'] }},</p>
        @endisset

        @isset($custom_tour['recipientName'])
            <p id="recipientName">for {{ $custom_tour['recipientName'] }}</p>
        @endisset

        <p>{{ count($custom_tour['artworks']) }} artworks, {{ $unique_artists_count }} artists across {{ $unique_galleries_count }} galleries</p>

        @if(array_key_exists('description', $custom_tour) && $custom_tour['description'])
            <p id="description">{{ $custom_tour['description'] }}</p>
        @endif

        <ul>
            @foreach ($custom_tour['artworks'] as $artwork)
                <li>
                    {{ $artwork['title'] }}
                    @isset($artwork['dateDisplay'])
                        , {{ $artwork['dateDisplay'] }}
                    @endisset
                    <ul>
                        @isset($artwork['artistTitle'])
                        <li>Artist title: {{ $artwork['artistTitle'] }}</li>
                        @endisset
                        @isset($artwork['imageId'])
                            <li>
                                <img src="https://www.artic.edu/iiif/2/{{ $artwork['imageId'] }}/full/256,/0/default.jpg" alt="Thumbnail for {{ $artwork['title'] }}">
                            </li>
                        @endisset
                        @isset($artwork['galleryTitle'])
                        <li>Gallery title: {{ $artwork['galleryTitle'] }}</li>
                        @endisset
                        @isset($artwork['objectNote'])
                        <li>Object note: {{ $artwork['objectNote'] }}</li>
                        @endisset
                        <li>Object page: <a href="https://www.artic.edu/artworks/{{ $artwork['id'] }}">Link</a></li>
                        @isset($artwork['description'])
                            <li>Object description: {{ $artwork['description'] }}</li>
                        @endisset
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
