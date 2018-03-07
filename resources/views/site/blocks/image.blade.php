@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', [
        'type' => 'image',
        'size' => $block->input('layout') === 1 ? 's' : 'm',
        'media' => [
            "src" => $image['src'],
            "srcset" => $image['src'],
            "width" => $image['width'],
            "height" => $image['height'],
        ]
    ])
@endcomponent

