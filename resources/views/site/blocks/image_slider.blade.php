@php
    $leftImage = $block->imageAsArray('left_image', 'default');
    $rightImage = $block->imageAsArray('right_image', 'default');

    $artwork_id = Arr::first($block->browserIds('artworks'));
    $artwork = \App\Models\Api\Artwork::query()->find($artwork_id);
@endphp

@if (isset($leftImage['src']) && isset($rightImage['src']))
    <div class="m-media m-media--l m-media--image_slider o-blocks__block">
        @component('components.molecules._m-image-slider')
            @slot('leftImage', [
                "src" => $leftImage['src'],
                "srcset" => $leftImage['src'],
                "width" => $leftImage['width'] ?? 0,
                "height" => $leftImage['height'] ?? 0,
                "alt" => $leftImage['alt'],
            ])
            @slot('rightImage', [
                "src" => $rightImage['src'],
                "srcset" => $rightImage['src'],
                "width" => $rightImage['width'] ?? 0,
                "height" => $rightImage['height'] ?? 0,
                "alt" => $rightImage['alt'],
            ])
            @slot('artwork', $artwork_id ? $artwork : '')
        @endcomponent
    </div>
@endif
