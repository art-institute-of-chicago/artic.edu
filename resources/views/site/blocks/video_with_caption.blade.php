@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', [
        'type' => 'video',
        'size' => $block->input('layout') === 1 ? 's' : 'm',
        'media' => [
            "src" => $block->input('url'),
            "srcset" => $image['src'],
            "width" => $image['width'],
            "height" => $image['height'],
            "shareUrl" => '#',
            "shareTitle" => $block->input('caption'),
            "downloadUrl" => $block->input('url'),
            "downloadName" => '',
            "credit" => '',
            "creditUrl" => '',
        ],
        'caption' => $block->input('caption')
    ])
@endcomponent
