@php
    $tag = $tag ?? 'aside';

    $href = $href ?? '#';
    $image = $image ?? null;
    $header = $header ?? null;
    $body = $body ?? null;
    $button_text = $button_text ?? null;
    $my_museum_tour = $my_museum_tour ?? false;
    $my_museum_tour_bottom = $my_museum_tour_bottom ?? false;
    $my_museum_tour_viewer = $my_museum_tour_viewer ?? false;
    $my_museum_tour_viewer_completed = $my_museum_tour_viewer_completed ?? false;
    $secondary_button_href = $secondary_button_href ?? null;
    $secondary_button_text = $secondary_button_text ?? null;

    // TODO: Make this an option?
    $isBigLink = isset($image);
@endphp

@if ($header)
    <div @class([
            'm-cta-banner--aic-ct-container' => isset($image) && $my_museum_tour,
            'm-cta-banner--aic-ct-viewer-container' => !isset($image) && $my_museum_tour_viewer,
            'm-cta-banner--aic-ct-viewer-container-completed' => !isset($image) && $my_museum_tour_viewer_completed,
            'm-cta-banner--aic-ct-bottom' => $my_museum_tour_bottom,
        ])>
        <{{ $tag }} @class([
                        'm-cta-banner',
                        'm-cta-banner--with-image' => isset($image),
                        isset($variation) ?? $variation,
                        'm-cta-banner--aic-ct' => $my_museum_tour,
                        'm-cta-banner--aic-ct-with-image' => isset($image) && $my_museum_tour,
                        'm-cta-banner--aic-ct-no-image' => !isset($image) && $my_museum_tour,
                    ])
            {!! isset($image) ? ' data-behavior="bannerParallax"' : '' !!}>
            @if ($isBigLink)
                <a href="{{ $href }}" class="m-cta-banner__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
            @endif
                @if (isset($image))
                    <div class="m-cta-banner__img" data-parallax-img>
                        @component('components.atoms._img')
                            @slot('image', $image)
                            @slot('settings', array(
                                'fit' => 'fill',
                                'ratio' => '25:4',
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
                        @if ($my_museum_tour)
                            <div class="m-cta-banner--aic-ct__overlay">
                            </div>
                        @endif
                    </div>
                @endif
                <div class="m-cta-banner__txt">
                    @if ($my_museum_tour)
                        <div class="m-cta-banner__txt--aic-ct-wrapper">
                    @endif
                    <div @class([
                            'm-cta-banner__title',
                            'f-headline' => $my_museum_tour,
                            'f-module-title-2' => !$my_museum_tour,
                        ])>
                            {!! SmartyPants::defaultTransform($header) !!}
                    </div>
                    @if ($body)
                        <div @class([
                            'm-cta-banner__msg',
                            'm-cta-banner__msg--aic-ct' => $my_museum_tour,
                            'f-body' => $my_museum_tour,
                            'f-list-2' => !$my_museum_tour,
                        ])>
                            {!! SmartyPants::defaultTransform($body) !!}
                        </div>
                    @endif
                    @if ($my_museum_tour)
                        </div>
                    @endif

                    @if ($button_text)
                        <div class="m-cta-banner__action">
                            @if (!$isBigLink)
                                <a href="{{ $href }}">
                            @endif

                            <span @class([
                                'btn',
                                'f-buttons',
                                'btn--contrast' => isset($image) && !$my_museum_tour,
                                'btn--quaternary' => !isset($image) && $my_museum_tour && !$secondary_button_href && !$my_museum_tour_viewer,
                                'btn--secondary' => !isset($image) && $my_museum_tour && $secondary_button_href,
                            ])>
                                {!! SmartyPants::defaultTransform($button_text) !!}
                            </span>
                            @if (!$isBigLink)
                                </a>
                            @endif

                            @if (!$isBigLink && $secondary_button_href && $secondary_button_text)
                                <a href="{{ $secondary_button_href }}">
                                    <span @class([
                                        'btn',
                                        'f-buttons',
                                        'btn--contrast' => isset($image) && !$my_museum_tour,
                                        'btn--quaternary' => !isset($image) && $my_museum_tour,
                                    ])>
                                        {!! SmartyPants::defaultTransform($secondary_button_text) !!}
                                    </span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @if ($isBigLink)
                </a>
            @endif
        </{{ $tag }}>
    </div>
@endif
