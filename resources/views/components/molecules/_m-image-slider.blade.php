@php
    $hash = md5(uniqid(rand(), true));
    $imageData = [
        'leftImage' => $leftImage,
        'rightImage' => $rightImage,
        'isSliderZoomable' => $isSliderZoomable,
        'zoomInButtonId' => 'm-image-slider__btn--zoom-in--' . $hash,
        'zoomOutButtonId' => 'm-image-slider__btn--zoom-out--' . $hash,
    ];
@endphp

<div class="m-image-slider">
    <div class="m-image-slider__viewer" data-behavior="imageSlider" data-images="{{ json_encode($imageData) }}">
        <div class="m-image-slider__handle"></div>
    </div>

    {{-- Adapted from `_fullscreenImage` --}}
    @if ($isSliderZoomable)
        <h2 class="sr-only" id="h-slider_action--{{ $hash }}">Image actions</h2>
        <ul class="m-image-slider__actions" aria-labelledby="h-slider_action--{{ $hash }}">
          <li>
            @component('components.atoms._btn')
                @slot('variation', 'btn--septenary btn--icon-sq')
                @slot('font', '')
                @slot('icon', 'icon--zoom-in--24')
                @slot('id', $imageData['zoomInButtonId'])
                @slot('ariaLabel', 'Zoom in')
            @endcomponent
          </li>
          <li>
            @component('components.atoms._btn')
                @slot('variation', 'btn--septenary btn--icon-sq')
                @slot('font', '')
                @slot('icon', 'icon--zoom-out--24')
                @slot('id', $imageData['zoomOutButtonId'])
                @slot('ariaLabel', 'Zoom out')
            @endcomponent
          </li>
        </ul>
    @endif
</div>
