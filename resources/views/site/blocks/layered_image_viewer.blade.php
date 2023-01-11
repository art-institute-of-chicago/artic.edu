<!-- @php
    $image = $block->imageAsArray('image', 'desktop');
@endphp -->

@php
    $images = [];
    foreach ($block->childs as $image) {
        $image->blocks = [
            [
                'type' => 'image',
                'size' => $block->input('size'),
                'media' => [
                    'src' => $image['src'],
                    'srcset' => $image['src'],
                    'width' => $image['width'] ?? 0,
                    'height' => $image['height'] ?? 0,
                    'alt' => $image['alt'],
                ],
            ]
        ];

        $images[] = $image;
    }
@endphp

@component('components.organisms._o-layered-image-viewer')
    @slot('variation', 'o-blocks__block')
    @slot('images', $images)
    @slot('loopIndex', $block->id)
@endcomponent