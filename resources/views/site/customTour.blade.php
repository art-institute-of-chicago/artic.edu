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
                    @isset($artwork['display_date'])
                        , {{ $artwork['display_date'] }}
                    @endisset
                    <ul>
                        @isset($artwork['artist_title'])
                        <li>Artist title: {{ $artwork['artist_title'] }}</li>
                        @endisset
                        @isset($artwork['image_id'])
                        <li>IIIF thumbnail:
                            <img src="https://www.artic.edu/iiif/2/{{ $artwork['image_id'] }}/full/256,/0/default.jpg"
                                alt="{{ isset($artwork['thumbnail']['alt_text']) ? $artwork['thumbnail']['alt_text'] : 'Thumbnail for ' . $artwork['title'] }}">
                        </li>
                        @endisset
                        @isset($artwork['gallery_title'])
                        <li>Gallery title: {{ $artwork['gallery_title'] }}</li>
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
