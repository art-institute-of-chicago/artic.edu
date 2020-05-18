@php
    $leftImage = $block->imageAsArray('left_image', 'default');
    $rightImage = $block->imageAsArray('right_image', 'default');

    $artwork_id = Arr::first($block->browserIds('artworks'));
    $artwork = \App\Models\Api\Artwork::query()->find($artwork_id);
@endphp

@if (isset($left_image['src']) && isset($right_image['src']))
    <div class="m-media m-media--l m-media--image_slider o-blocks__block">
        @component('components.molecules._m-image-slider')
            @slot('leftImage', [
                "src" => $left_image['src'],
                "srcset" => $left_image['src'],
                "width" => $left_image['width'] ?? 0,
                "height" => $left_image['height'] ?? 0,
                "alt" => $left_image['alt'],
            ])
            @slot('rightImage', [
                "src" => $left_image['src'],
                "srcset" => $left_image['src'],
                "width" => $left_image['width'] ?? 0,
                "height" => $left_image['height'] ?? 0,
                "alt" => $left_image['alt'],
            ])
            @slot('artwork', $artwork_id ? $artwork : '')
        @endcomponent
    </div>
@endif
