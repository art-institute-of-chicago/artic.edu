@php
    if (!isset($href)) {
        $href = '#';
    }
    if (!isset($image)) {
        $image = null;
    }
@endphp
<aside class="m-cta-banner m-cta-banner--parallax{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="bannerParallax">
    <a href="{{ $href }}">
        <div class="m-cta-banner__img" data-parallax-img>
            @component('components.atoms._img')
                @slot('image', $image)
                @slot('settings', array(
                    'fit' => 'crop',
                    'ratio' => '25:3',
                    'srcset' => array(300,600,1000,1500,2000),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '58',
                          'medium' => '58',
                          'large' => '58',
                          'xlarge' => '58',
                    )),
                ))
            @endcomponent
        </div>
        <div class="m-cta-banner__txt">
            <p class="m-cta-banner__title f-module-title-2">Become a Member</p>
            <p class="m-cta-banner__msg f-list-2">Join today and get <em>exclusive access</em> to the Art Institute of Chicago.</p>
            <p class="m-cta-banner__action"><span class="btn f-buttons btn--contrast">Learn More</span></p>
        </div>
    </a>
</aside>
