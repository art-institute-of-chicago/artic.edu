@php
    $image = [];
@endphp

@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', [
        'type' => 'embed',
        'size' => 'm',
        'media' => [
            "src" => $block->input('source_url'),
            "srcset" => $image['src'],
            "width" => $image['width'],
            "height" => $image['height'],
            "shareUrl" => '#',
            "shareTitle" => '',
            "downloadUrl" => $block->input('source_url'),
            "downloadName" => '',
            "credit" => '',
            "creditUrl" => '',
        ],
        'caption' => ''
    ])
@endcomponent
