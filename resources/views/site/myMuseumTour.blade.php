@extends('layouts.app')

@section('content')
    @if ($tour_creation_completed)
        <div class="aic-ct-flash-message o-article__body">
            <div class="aic-ct-flash-message__text-container">
                <h1 class="f-headline">Great job! Your tour is complete.</h1>
                <p class="f-body">Your tour has been emailed to the address provided. Here is a link to share with friends.</p>
                <div class="aic-ct-viewer__link-container">
                    <p class="f-subheading-1">{{ preg_replace("(^https?://)", "", url()->current() )}}</p>
                </div>
                @component('components.molecules._m-article-actions')
                    @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
                    @slot('hidePrint', true)
                    @slot('btnVariation', 'btn--my-museum-tour-dark')
                @endcomponent
            </div>
        </div>
    @endif
    <article class="aic-ct-viewer o-article o-article__body">
        <div class="aic-ct-viewer__header ">
           <div class="aic-ct-viewer__header-wrapper">
                <a href="{{ route('pages.slug', ['slug' => 'my-museum-tour']) }}"><h1 class="aic-ct-title">My Museum Tour</h1></a>
                @component('components.atoms._img')
                    @slot('image', $hero_media)
                    @slot('settings', array(
                        'fit' => 'crop',
                        'srcset' => array(300,600,1000,1500,2000),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                            'xsmall' => '272',
                            'small' => '544',
                            'medium' => '907',
                            'large' => '1087',
                            'xlarge' => '725',
                        )),
                    ))
                    @slot('class', 'aic-ct-viewer__header-img')
                @endcomponent
                @component('components.atoms._img')
                    @slot('image', $mobile_hero_media)
                    @slot('settings', array(
                        'fit' => 'crop',
                        'srcset' => array(300,600,1000,1500,2000),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                            'xsmall' => '272',
                            'small' => '544',
                            'medium' => '907',
                            'large' => '1087',
                            'xlarge' => '725',
                        )),
                    ))
                    @slot('class', 'aic-ct-viewer__header-img-mobile')
                @endcomponent
           </div>
        </div>
        <div>
            <div class="aic-ct-viewer__creator-container">
                <h2 class="aic-ct-title">{{$my_museum_tour['title']}}</h2>
                @isset($my_museum_tour['creatorName'])
                    <p class="f-subheading-1">
                        <span id="creatorName">Tour made by {{ $my_museum_tour['creatorName'] }}</span>
                        @isset($my_museum_tour['recipientName'])
                            <span id="recipientName">for {{ $my_museum_tour['recipientName'] }}</span>
                        @endisset
                    </p>
                @endisset
            </div>

            <div class="aic-ct-artworks-count-container">
                <svg aria-hidden="true" class="icon--image-stack"><use xlink:href="#icon--image-stack" /></svg>
                <div class="f-module-title-1">
                    <p><strong>{{ count($my_museum_tour['artworks']) }} {{ Str::plural('artwork', count($my_museum_tour['artworks'])) }} </strong> <em>from</em> <strong>{{ $unique_artists_count }} {{ Str::plural('artist', $unique_artists_count) }} </strong> <em>across</em> <strong>{{ $unique_galleries_count }} {{ Str::plural('gallery', $unique_galleries_count) }}</strong><br/>
                    The tour will begin from the Michigan Avenue entrance, if you enter from the Modern Wing, begin your tour in reverse order.</p>
                </div>
            </div>

            <hr>

            @if(array_key_exists('description', $my_museum_tour) && $my_museum_tour['description'])
                @component('components.atoms._quote')
                    @slot('variation', 'quote--editorial o-blocks__block aic-ct-quote--large')
                    @slot('font', 'f-quote')
                    @slot('attribution', (isset($my_museum_tour['creatorName'])) ? '— ' . $my_museum_tour['creatorName'] : '')
                    {{ $my_museum_tour['description'] }}
                @endcomponent
            @endif

            @component('components.molecules._m-article-actions')
                @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
                @slot('hidePrint', true)
                @slot('btnVariation', 'btn--my-museum-tour-dark')
            @endcomponent

            <ul class="aic-ct-artworks-list">
                @foreach ($my_museum_tour['artworks'] as $artwork)
                    <li class="aic-ct-list-item">
                        @if((!$loop->first && !$tour_creation_completed) || $tour_creation_completed)
                            <hr>
                        @endif
                        @isset($artwork['image_id'])
                            <div class="aic-ct-list-item__artwork-img-container">
                                @php
                                    $artwork_image = [
                                        "sourceType" => "imgix",
                                        "src" => "https://www.artic.edu/iiif/2/" . $artwork['image_id'] . "/full/!1087,700/0/default.jpg",
                                        "shareUrl" => "#",
                                        "shareTitle" => "",
                                        "downloadUrl" => "https://www.artic.edu/iiif/2/" . $artwork['image_id'] . "/full/!1087,700/0/default.jpg",
                                        "credit" => "",
                                        "creditUrl" => "",
                                        "lqip" => null,
                                        "alt" => isset($artwork['thumbnail']['alt_text']) ? $artwork['thumbnail']['alt_text'] : $artwork['title'],
                                        "caption" => null,
                                        "iiifId" => null,
                                        "restrict" => false,
                                    ];
                                @endphp
                                <a href="{{ config('aic.protocol') }}://{{ rtrim(config('app.url')) }}/artworks/{{ $artwork['id'] }}"
                                   aria-label="View full artwork page for {{ $artwork['title'] }}{{ isset($artwork['thumbnail']['alt_text']) ? ': ' . $artwork['thumbnail']['alt_text'] : '' }}">
                                    @component('components.atoms._img')
                                        @slot('image', $artwork_image)
                                        @slot('settings', array(
                                            'fit' => 'crop',
                                            'srcset' => array(300,600,1000,1500,2000),
                                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                                  'xsmall' => '272',
                                                  'small' => '544',
                                                  'medium' => '907',
                                                  'large' => '1087',
                                                  'xlarge' => '725',
                                            )),
                                        ))
                                    @endcomponent
                                </a>
                            </div>
                        @endisset
                        <h2 class="f-deck">{{ $artwork['title'] }}</h2>
                        @isset($artwork['artist_title'])
                            <p class="f-body">
                                {{ $artwork['artist_title'] }}{{ isset($artwork['display_date']) ? ',' : '' }}
                                @isset($artwork['display_date'])
                                    {{ $artwork['display_date'] }}
                                @endisset
                            </p>
                        @endisset

                        @isset($artwork['gallery_title'], $artwork['gallery_level'], $artwork['gallery_location'])
                            <div class="aic-ct-viewer__gallery-container">
                                <p class="f-tertiary">
                                    {{ $artwork['gallery_title'] }}, {{ $artwork['gallery_level'] }}, {{ $artwork['gallery_location'] }}
                                </p>
                            </div>
                        @endisset
                        @isset($artwork['description'])
                            <p class="f-tertiary aic-ct-viewer__description">{{ $artwork['description'] }}</p>
                        @endisset
                        @isset($artwork['objectNote'])
                            @component('components.atoms._quote')
                                @slot('variation', 'quote--editorial o-blocks__block aic-ct-quote--small')
                                @slot('font', 'f-body-editorial-emphasis')
                                @slot('icon', false)
                                @slot('attribution', (isset($my_museum_tour['creatorName'])) ? '— ' . $my_museum_tour['creatorName'] : '')
                                "{{ $artwork['objectNote'] }}"
                            @endcomponent
                        @endisset
                        <a href="{{ config('aic.protocol') }}://{{ rtrim(config('app.url')) }}/artworks/{{ $artwork['id'] }}"
                           target="_blank"
                           class="external-link f-link"
                           aria-hidden="true">
                                View full artwork page<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="aic-ct-viewer__share-container">
                <p class="f-headline">Thanks for taking my tour.</p>
                @component('components.molecules._m-article-actions')
                    @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
                    @slot('hidePrint', true)
                    @slot('btnVariation', 'btn--my-museum-tour-dark')
                @endcomponent
            </div>
        </div>
    </article>


    @component('components.molecules._m-cta-banner')
        @slot('image', $tours_create_cta_module_image)
        @slot('href', 'https://sales.artic.edu/admissions')
        @slot('header', 'Plan a visit to take your tour!')
        @slot('button_text', 'Buy Tickets')
        @slot('body', '<p>The best way to experience your new tour is in the galleries&mdash;with the artworks you&apos;ve chosen.</p>')
        @slot('gtmAttributes', 'data-gtm-event="Buy tickets" data-gtm-event-category="internal-ad-click"')
        @slot('my_museum_tour', true)
    @endcomponent

    @component('components.molecules._m-cta-banner')
        @slot('image', $tours_tickets_cta_module_image)
        @slot('href', '/my-museum-tour/builder')
        @slot('header', 'Ready to build your own tour?')
        @slot('body', '<p>Design a personalized tour by directly searching artworks or exploring themes that can help you get started.</p>')
        @slot('button_text', 'Create your own tour')
        @slot('gtmAttributes', 'data-gtm-event="Create your own tour" data-gtm-event-category="internal-ad-click"')
        @slot('my_museum_tour', true)
        @slot('secondary_button_href', '/my-museum-tour')
        @slot('secondary_button_text', 'View ready-made tours')
        @slot('my_museum_tour_bottom', true)
    @endcomponent
@endsection
