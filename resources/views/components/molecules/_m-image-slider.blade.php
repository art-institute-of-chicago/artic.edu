@php
    $defaultSrcset = array(300,600,800,1200,1600,2000,3000,4500);
    $imageSettings = array(
        'srcset' => $defaultSrcset,
        'sizes' => aic_imageSizes(array(
            'xsmall' => '58',
            'small' => '58',
            'medium' => '38',
            'large' => '28',
            'xlarge' => '28',
    )));
@endphp

<div class="m-image-slider" data-behavior="imageSlider">
  <figure class="m-image-slider__image-container">
    @component('components.atoms._img')
        @slot('image', $leftImage)
        @slot('settings', $imageSettings)
    @endcomponent
    <span class="m-image-slider__label" data-type="original">Original</span>

    <div class="m-image-slider__resize-img"> <!-- the resizable image on top -->
        @component('components.atoms._img')
            @slot('image', $rightImage)
            @slot('settings', $imageSettings)
        @endcomponent
      <span class="m-image-slider__label" data-type="modified">Modified</span>
    </div>

    <span class="m-image-slider__handle"></span> <!-- slider handle -->
  </figure>
  <div class="m-image-slider__tools">
    <button class="m-image-slider__fullscreen" type="button" aria-label="Fullscreen">
      <svg class="icon-normal" width="32" height="32" viewBox="0 0 32 32">
        <path fill="#ffffff" d="M29.92,2.62a1.15,1.15,0,0,0-.21-.33,1.15,1.15,0,0,0-.33-.21A1,1,0,0,0,29,2H21a1,1,0,0,0,0,2h5.59l-8.3,8.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L28,5.41V11a1,1,0,0,0,2,0V3A1,1,0,0,0,29.92,2.62Z"/>
        <path fill="#ffffff" d="M5.41,4H11a1,1,0,0,0,0-2H3a1,1,0,0,0-.38.08,1.15,1.15,0,0,0-.33.21,1.15,1.15,0,0,0-.21.33A1,1,0,0,0,2,3v8a1,1,0,0,0,2,0V5.41l8.29,8.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/>
        <path fill="#ffffff" d="M29,20a1,1,0,0,0-1,1v5.59l-8.29-8.3a1,1,0,0,0-1.42,1.42L26.59,28H21a1,1,0,0,0,0,2h8a1,1,0,0,0,.38-.08.9.9,0,0,0,.54-.54A1,1,0,0,0,30,29V21A1,1,0,0,0,29,20Z"/>
        <path fill="#ffffff" d="M12.29,18.29,4,26.59V21a1,1,0,0,0-2,0v8a1,1,0,0,0,.08.38,1.15,1.15,0,0,0,.21.33,1.15,1.15,0,0,0,.33.21A1,1,0,0,0,3,30h8a1,1,0,0,0,0-2H5.41l8.3-8.29a1,1,0,0,0-1.42-1.42Z"/>
      </svg>
      <svg class="icon-active" width="32" height="32" viewBox="0 0 32 32">
        <path fill="#ffffff" d="M10.9,19.4H4c-0.9,0-1.7,0.8-1.7,1.7s0.8,1.7,1.7,1.7h5.1V28c0,0.9,0.8,1.7,1.7,1.7c0.9,0,1.7-0.8,1.7-1.7v-6.9C12.6,20.2,11.8,19.4,10.9,19.4C10.9,19.4,10.9,19.4,10.9,19.4z"/>
        <path fill="#ffffff" d="M28,19.4h-6.9c-0.9,0-1.7,0.8-1.7,1.7c0,0,0,0,0,0V28c0,0.9,0.8,1.7,1.7,1.7s1.7-0.8,1.7-1.7v-5.1H28c0.9,0,1.7-0.8,1.7-1.7S28.9,19.4,28,19.4z"/>
        <path fill="#ffffff" d="M21.1,12.6H28c0.9,0,1.7-0.8,1.7-1.7c0-0.9-0.8-1.7-1.7-1.7h-5.1V4c0-0.9-0.8-1.7-1.7-1.7S19.4,3.1,19.4,4v6.9C19.4,11.8,20.2,12.6,21.1,12.6C21.1,12.6,21.1,12.6,21.1,12.6z"/>
        <path fill="#ffffff" d="M10.9,2.3C9.9,2.3,9.1,3.1,9.1,4c0,0,0,0,0,0v5.1H4c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7h6.9c0.9,0,1.7-0.8,1.7-1.7c0,0,0,0,0,0V4C12.6,3.1,11.8,2.3,10.9,2.3C10.9,2.3,10.9,2.3,10.9,2.3z"/>
      </svg>
    </button>
  </div>
  @if (isset($artwork) and $artwork)
  <a href="/artworks/{{ $artwork->id }}" class="m-image-slider__more">Learn more</a>
  @endif
</div>
