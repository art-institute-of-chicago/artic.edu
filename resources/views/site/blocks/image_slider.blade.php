@php
    $leftImage = $block->getImgixTileSource('left_image');
    $rightImage = $block->getImgixTileSource('right_image');
@endphp

@if (isset($leftImage) && isset($rightImage))
    <div class="m-media m-media--l o-blocks__block">
        @component('components.molecules._m-image-slider')
            @slot('leftImage', $leftImage)
            @slot('rightImage', $rightImage)
            @slot('isSliderZoomable', $block->input('is_slider_zoomable'))
        @endcomponent
    </div>
@endif
