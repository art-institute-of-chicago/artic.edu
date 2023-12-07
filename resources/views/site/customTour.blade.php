@extends('layouts.app')

@section('content')
    @php
        $hero_media = [
            "type" => "image",
            "size" => "hero",
            "hideCaption" => true,
            "style" => "default",
            "media" => [
                "sourceType" => "imgix",
                "src" => "https://www.artic.edu/iiif/2/3c27b499-af56-f0d5-93b5-a7f2f1ad5813/full/1920,1000/0/default.jpg",
                "width" => 1920,
                "height" => 1000,
                "shareUrl" => "#",
                "shareTitle" => "",
                "downloadUrl" => "https://www.artic.edu/iiif/2/3c27b499-af56-f0d5-93b5-a7f2f1ad5813/full/1920,1000/0/default.jpg",
                "downloadName" => "default.jpg",
                "credit" => "",
                "creditUrl" => "",
                "lqip" => null,
                "alt" => "A serene pond filled with floating lily pads and pink water lilies. The surrounding trees can also be seen in the ponds reflection.",
                "caption" => null,
                "iiifId" => null,
                "restrict" => false,
            ]
        ];
    @endphp
    @if ($tour_creation_completed)
        <div class="aic-ct-flash-message o-article__body">
            <div class="aic-ct-flash-message__text-container">
                <h1 class="f-headline">Great job! Your tour is complete</h1>
                <p class="f-body">Your tour has been emailed to you. Here is a link to share with friends.</p>
                <div class="aic-ct-viewer__link-container">
                    <p class="f-subheading-1">{{ preg_replace("(^https?://)", "", url()->current() )}}</p>
                </div>
                @component('components.molecules._m-article-actions')
                @endcomponent
            </div>
            @component('components.molecules._m-cta-banner')
                @slot('href', 'https://sales.artic.edu/admissions')
                @slot('header', 'View your tour below or visit us in person.')
                @slot('button_text', 'Buy tickets')
                @slot('custom_tours', true)
                @slot('custom_tours_viewer', true)
                @slot('custom_tours_viewer_completed', true)
            @endcomponent
        </div>
    @endif
    <article class="aic-ct-viewer o-article o-article__body">
        <div class="aic-ct-viewer__hero-img-container">
            @component('components.molecules._m-media')
                @slot('item', $hero_media)
                @slot('tag', 'span')
                @slot('imageSettings', array(
                    'srcset' => array(300,600,1000,1500,3000),
                    'sizes' => '100vw',
                ))
                @slot('variation', 'm-visit-header')
            @endcomponent
        </div>
        <h1 class="f-headline-editorial">{!! $custom_tour['title'] !!}</h1>
        <div>
            @isset($custom_tour['creatorName'])
                <div class="aic-ct-viewer__creator-container">
                    <p class="f-subheading-1">
                        <span id="creatorName">Tour made by {{ $custom_tour['creatorName'] }}{{ isset($custom_tour['recipientName']) ? ',' : '' }}</span>
                        @isset($custom_tour['recipientName'])
                            <span id="recipientName">for {{ $custom_tour['recipientName'] }}</span>
                        @endisset
                    </p>
                </div>
            @endisset

            <div class="aic-ct-artworks-count-container">
                <svg aria-hidden="true" class="icon--image-stack"><use xlink:href="#icon--image-stack" /></svg>
                <div class="f-module-title-1">
                    <p><strong>{{ count($custom_tour['artworks']) }} artworks</strong> <em>from</em> <strong>{{ $unique_artists_count }} artists</strong> <em>across</em> <strong>{{ $unique_galleries_count }} galleries</strong></p>
                </div>
            </div>

            <hr>

            @if(array_key_exists('description', $custom_tour) && $custom_tour['description'])
                @component('components.atoms._quote')
                    @slot('variation', 'quote--editorial o-blocks__block aic-ct-quote--large')
                    @slot('font', 'f-quote')
                    @slot('attribution', (isset($custom_tour['creatorName'])) ? '— ' . $custom_tour['creatorName'] : '')
                    {{ $custom_tour['description'] }}
                @endcomponent
            @endif

            @component('components.molecules._m-article-actions')
            @endcomponent

            @if (!$tour_creation_completed)
                @component('components.molecules._m-cta-banner')
                    @slot('href', 'https://sales.artic.edu/admissions')
                    @slot('header', 'View your tour below or visit us in person.')
                    @slot('button_text', 'Buy tickets')
                    @slot('custom_tours', true)
                    @slot('custom_tours_viewer', true)
                @endcomponent
            @endif

            <ul class="aic-ct-artworks-list">
                @foreach ($custom_tour['artworks'] as $artwork)
                    <li class="aic-ct-list-item">
                        @if((!$loop->first && !$tour_creation_completed) || $tour_creation_completed)
                            <hr>
                        @endif
                        @isset($artwork['image_id'])
                            <div class="aic-ct-list-item__artwork-img-container">
                                @php
                                    $artwork_image = [
                                        "sourceType" => "imgix",
                                        "src" => "https://www.artic.edu/iiif/2/" . $artwork['image_id'] . "/full/,500/0/default.jpg",
                                        "shareUrl" => "#",
                                        "shareTitle" => "",
                                        "downloadUrl" => "https://www.artic.edu/iiif/2/" . $artwork['image_id'] . "/full/,500/0/default.jpg",
                                        "credit" => "",
                                        "creditUrl" => "",
                                        "lqip" => null,
                                        "alt" => isset($artwork['thumbnail']['alt_text']) ? $artwork['thumbnail']['alt_text'] : $artwork['title'],
                                        "caption" => null,
                                        "iiifId" => null,
                                        "restrict" => false,
                                    ];
                                @endphp
                                @component('components.atoms._img')
                                    @slot('image', $artwork_image)
                                    @slot('settings', array(
                                        'fit' => 'crop',
                                        'srcset' => array(300,600,1000,1500,2000),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                              'xsmall' => '58',
                                              'small' => '58',
                                              'medium' => '58',
                                              'large' => '58',
                                              'xlarge' => '58',
                                        )),
                                    ))
                                @endcomponent
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

                        @isset($artwork['gallery_title'])
                            <div class="aic-ct-viewer__gallery-container">
                                <svg aria-hidden="true" class="icon--location"><use xlink:href="#icon--location" /></svg>
                                <p class="f-tertiary">{{ $artwork['gallery_title'] }}</p>
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
                                @slot('attribution', (isset($custom_tour['creatorName'])) ? '— ' . $custom_tour['creatorName'] : '')
                                "{{ $artwork['objectNote'] }}"
                            @endcomponent
                        @endisset
                        <a href="https://www.artic.edu/artworks/{{ $artwork['id'] }}"
                           target="_blank"
                           class="external-link f-link"
                           aria-label="View full artwork page for {{ $artwork['title'] }}, link opens in a new window">
                                View full artwork page<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="aic-ct-viewer__share-container">
                <p class="f-headline">Thanks for taking my tour</p>
                @component('components.molecules._m-article-actions')
                @endcomponent
            </div>
        </div>
    </article>

    @php
        $cta_image = [
            "sourceType" => "imgix",
            "src" => "https://artic-web.imgix.net/a1d91c0c-697b-42ef-b2a3-61a6a3a2da60/Art-Institute-FC-1222-0479.jpg?auto=compress%2Cformat&fit=min&fm=jpg&q=80&rect=0%2C1040%2C6238%2C991",
            "width" => 6238,
            "height" => 991,
            "shareUrl" => "#",
            "shareTitle" => "",
            "downloadUrl" => "https://artic-web.imgix.net/a1d91c0c-697b-42ef-b2a3-61a6a3a2da60/Art-Institute-FC-1222-0479.jpg?auto=compress%2Cformat&fit=min&fm=jpg&q=80&rect=0%2C1040%2C6238%2C991",
            "downloadName" => "Art-Institute-FC-1222-0479.jpg",
            "credit" => "",
            "creditUrl" => "",
            "lqip" => null,
            "alt" => "A gallery at the Art Institute of Chicago, where several people can be seen admiring various artworks.",
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
        @slot('custom_tours_bottom', true)
    @endcomponent
@endsection


