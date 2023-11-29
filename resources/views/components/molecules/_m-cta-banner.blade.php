@php
    $tag = $tag ?? 'aside';

    $href = $href ?? '#';
    $image = $image ?? null;
    $header = $header ?? null;
    $body = $body ?? null;
    $button_text = $button_text ?? null;
    $custom_tours = $custom_tours ?? false;
    $custom_tours_viewer = $custom_tours_viewer ?? false;
    $secondary_button_href = $secondary_button_href ?? null;
    $secondary_button_text = $secondary_button_text ?? null;

    // TODO: Make this an option?
    $isBigLink = isset($image);
@endphp

@if ($header)
    <div @class([
            'm-cta-banner--aic-ct-container' => isset($image) && $custom_tours,
            'm-cta-banner--aic-ct-viewer-container' => !isset($image) && $custom_tours_viewer,
        ])>
        <{{ $tag }} @class([
                        'm-cta-banner',
                        'm-cta-banner--with-image' => isset($image),
                        isset($variation) ?? $variation,
                        'm-cta-banner--aic-ct' => $custom_tours,
                        'm-cta-banner--aic-ct-with-image' => isset($image) && $custom_tours,
                        'm-cta-banner--aic-ct-no-image' => !isset($image) && $custom_tours,
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
                                'fit' => 'crop',
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
                        @if ($custom_tours)
                            <div class="m-cta-banner--aic-ct__overlay">
                            </div>
                        @endif
                    </div>
                @endif
                <div class="m-cta-banner__txt">
                    <div @class([
                            'm-cta-banner__title',
                            'f-headline' => $custom_tours,
                            'f-module-title-2' => !$custom_tours,
                        ])>
                            {!! SmartyPants::defaultTransform($header) !!}
                    </div>
                    @if ($body)
                        <div @class([
                            'm-cta-banner__msg',
                            'm-cta-banner__msg--aic-ct' => $custom_tours,
                            'f-body' => $custom_tours,
                            'f-list-2' => !$custom_tours,
                        ])>
                            {!! SmartyPants::defaultTransform($body) !!}
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
                                'btn--contrast' => isset($image) && !$custom_tours,
                                'btn--quaternary' => !isset($image) && $custom_tours && !$secondary_button_href && !$custom_tours_viewer,
                                'btn--secondary' => !isset($image) && $custom_tours && $secondary_button_href,
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
                                        'btn--contrast' => isset($image) && !$custom_tours,
                                        'btn--quaternary' => !isset($image) && $custom_tours,
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
