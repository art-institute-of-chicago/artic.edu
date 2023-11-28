@extends('layouts.app')

@section('content')
    <article class="aic-ct-viewer o-article">
        <img src=""/>

        <h2 class="f-headline-editorial">{!! $custom_tour['title'] !!}</h2>
        {{-- Todo: Do you need the o-blocks class? --}}
        <div class="o-blocks aic-ct-viewer__creator-container">
            @isset($custom_tour['creatorName'])
                <p class="f-subheading-1">
                    <span id="creatorName">Tour made by {{ $custom_tour['creatorName'] }}{{ isset($custom_tour['recipientName']) ? ',' : '' }}</span>
                    @isset($custom_tour['recipientName'])
                        <span id="recipientName">for {{ $custom_tour['recipientName'] }}</span>
                    @endisset
                </p>
            @endisset

            <div class="aic-ct-artworks-count-container">
                <svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--image-stack" /></svg>
                <div class="f-module-title-1">
                    <p><strong>{{ count($custom_tour['artworks']) }} artworks</strong> <em>from</em> <strong>{{ $unique_artists_count }} artists</strong> <em>across</em> <strong>{{ $unique_galleries_count }} galleries</strong></p>
                </div>
            </div>

            <hr />

            @if(array_key_exists('description', $custom_tour) && $custom_tour['description'])
                <div class="aic-ct-quote-container">
                    <p id="description" class="f-body-editorial-emphasis">{{ $custom_tour['description'] }}</p>
                    <p class="f-secondary">— Joe</p>
                </div>
            @endif

            @component('components.molecules._m-article-actions')
            @endcomponent

            {{--        @component('components.molecules._m-cta-banner')--}}
            {{--            @slot('href', 'https://sales.artic.edu/admissions')--}}
            {{--            @slot('header', 'View your tour below or visit us in person.')--}}
            {{--            @slot('button_text', 'Buy tickets')--}}
            {{--            @slot('custom_tours', true)--}}
            {{--        @endcomponent--}}
            <ul>
                @foreach ($custom_tour['artworks'] as $artwork)
                    <hr />
                    <li class="aic-ct-list-item">
                        @isset($artwork['image_id'])
                            <img src="https://www.artic.edu/iiif/2/{{ $artwork['image_id'] }}/full/256,/0/default.jpg"
                                 alt="{{ isset($artwork['thumbnail']['alt_text']) ? $artwork['thumbnail']['alt_text'] : $artwork['title'] }}">
                        @endisset
                        <h2>{{ $artwork['title'] }}</h2>
                        @isset($artwork['artist_title'])
                            <p>
                                {{ $artwork['artist_title'] }}{{ isset($artwork['display_date']) ? ',' : '' }}
                                @isset($artwork['display_date'])
                                    {{ $artwork['display_date'] }}
                                @endisset
                            </p>
                        @endisset

                        @isset($artwork['gallery_title'])
                            <p>{{ $artwork['gallery_title'] }}</p>
                        @endisset
                        @isset($artwork['description'])
                            <p>{{ $artwork['description'] }}</p>
                        @endisset
                        @isset($artwork['objectNote'])
                            <div class="aic-ct-quote-container">
                                <p class="f-body-editorial-emphasis">{{ $artwork['objectNote'] }}</p>
                                <p class="f-secondary">— Joe</p>
                            </div>
                        @endisset
                        <a href="https://www.artic.edu/artworks/{{ $artwork['id'] }}" target="_blank" class="external-link f-link">
                            View full artwork page<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr />
            <div class="aic-ct-share-container">
                <p class="f-headline">Thanks for taking my tour</p>
                @component('components.molecules._m-article-actions')
                @endcomponent
            </div>
        </div>

    </article>


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

    @component('components.molecules._m-cta-banner')
        @slot('href', '/custom-tours/builder')
        @slot('header', 'Create your own custom tour')
        @slot('body', 'Ready to build your own tour? Click the "Create tour" button to search available artworks or to see a list of themes that can help get you started.')
        @slot('button_text', 'Create your own tour')
        @slot('custom_tours', true)
        @slot('secondary_button_href', '/custom-tours')
        @slot('secondary_button_text', 'View ready-made tours')
    @endcomponent
@endsection


