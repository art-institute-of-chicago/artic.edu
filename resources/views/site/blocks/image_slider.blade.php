@php
    $leftImage = $block->getImgixTileSource('left_image');
    $rightImage = $block->getImgixTileSource('right_image');

    $referenceImage = $block->imageAsArray('left_image', 'default');
@endphp

@if (isset($leftImage) && isset($rightImage))
    @component('components.molecules._m-image-slider')
        @slot('variation', 'o-blocks__block')
        @slot('size', $block->input('size'))
        @slot('captionTitle', $block->present()->input('caption_title'))
        @slot('captionText', $block->present()->input('caption_text'))
        @slot('leftImage', $leftImage)
        @slot('rightImage', $rightImage)
        @slot('referenceImage', $referenceImage)
        @slot('width', $referenceImage['width'] ?? 16)
        @slot('height', $referenceImage['height'] ?? 10)
        @slot('isSliderZoomable', $block->input('is_slider_zoomable'))
    @endcomponent
@endif
