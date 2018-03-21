@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', [
        'type' => 'image',
        'size' => $block->input('size'),
        'caption' => $block->input('caption'),
        'captionTitle' => $block->input('caption_title'),
        'media' => [
            "src" => $image['src'],
            "srcset" => $image['src'],
            "width" => $image['width'],
            "height" => $image['height'],
            "shareUrl" => '#',
            "shareTitle" => $block->input('caption'),
            "downloadUrl" => $image['src'],
            "downloadName" => '',
            "credit" => '',
            "creditUrl" => '',
        ],
    ])
@endcomponent

