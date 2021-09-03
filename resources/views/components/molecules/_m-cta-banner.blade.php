@php
    $tag = $tag ?? 'aside';

    $href = $href ?? '#';
    $image = $image ?? null;
    $header = $header ?? null;
    $body = $body ?? null;
    $button_text = $button_text ?? null;

    // TODO: Make this an option?
    $isBigLink = isset($image);
@endphp
<{{ $tag }} class="m-cta-banner{{ isset($image) ? ' m-cta-banner--with-image' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! isset($image) ? ' data-behavior="bannerParallax"' : '' !!}>
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
            </div>
        @endif
        <div class="m-cta-banner__txt">
            <div class="m-cta-banner__title f-module-title-2">{!! SmartyPants::defaultTransform($header) !!}</div>
            <div class="m-cta-banner__msg f-list-2">{!! SmartyPants::defaultTransform($body) !!}</div>
            <div class="m-cta-banner__action">
                @if (!$isBigLink)
                    <a href="{{ $href }}">
                @endif
                <span class="btn f-buttons{{ isset($image) ? ' btn--contrast' : '' }}">{!! SmartyPants::defaultTransform($button_text) !!}</span>
                @if (!$isBigLink)
                    </a>
                @endif
            </div>
        </div>
    @if ($isBigLink)
        </a>
    @endif
</{{ $tag }}>
