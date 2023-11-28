@extends('layouts.app')

@section('content')
    <img src=""/>

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
                                alt="{{ isset($artwork['thumbnail']['alt_text']) ? $artwork['thumbnail']['alt_text'] : $artwork['title'] }}">
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

    {{-- Todo: Put the CTA blocks in a separate file? Use local src and downloadUrl? Update alt text. --}}
    @php
        $cta_image = [
            "sourceType" => "imgix",
            "src" => "https://artic-web-test.imgix.net/a1d91c0c-697b-42ef-b2a3-61a6a3a2da60/Art-Institute-FC-1222-0479.jpg?auto=compress%2Cformat&fit=min&fm=jpg&q=80&rect=0%2C1040%2C6238%2C991",
            "width" => 6238,
            "height" => 991,
            "shareUrl" => "#",
            "shareTitle" => "",
            "downloadUrl" => "https://artic-web-test.imgix.net/a1d91c0c-697b-42ef-b2a3-61a6a3a2da60/Art-Institute-FC-1222-0479.jpg?auto=compress%2Cformat&fit=min&fm=jpg&q=80&rect=0%2C1040%2C6238%2C991",
            "downloadName" => "Art-Institute-FC-1222-0479.jpg",
            "credit" => "",
            "creditUrl" => "",
            "lqip" => null,
            "alt" => "Art Institute Fc 1222 0479",
            "caption" => null,
            "iiifId" => null,
            "restrict" => false,
        ];
    @endphp

    @component('components.molecules._m-cta-banner')
        @slot('image', $cta_image)
        @slot('href', 'https://sales.artic.edu/admissions')
        @slot('header', 'Custom tours are even better in real life')
        @slot('body', 'Plan a visit and take your tour!')
        @slot('button_text', 'Buy tickets')
        @slot('gtmAttributes', 'data-gtm-event="Buy tickets" data-gtm-event-category="internal-ad-click"')
        @slot('custom_tours', true)
    @endcomponent

    {{-- Todo: Set $isBigLink to true and add gtmAttributes? --}}
    @component('components.molecules._m-cta-banner')
        @slot('header', 'Create your own custom tour')
        @slot('body', 'Ready to build your own tour? Click the "Create tour" button to search available artworks or to see a list of themes that can help get you started.')
        @slot('button_text', 'Create your own tour')
        @slot('custom_tours', true)
    @endcomponent
@endsection


