@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@if (isset($image['src']))
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'image',
            'size' => $block->input('size'),
            'media' => [
                'src' => $image['src'],
                'srcset' => $image['src'],
                'width' => $image['width'] ?? 0,
                'height' => $image['height'] ?? 0,
                'alt' => $image['alt'],
            ],
        ])
    @endcomponent
@endif