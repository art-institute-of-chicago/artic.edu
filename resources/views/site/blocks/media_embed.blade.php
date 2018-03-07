@php
    $image = $block->imageAsArray('image', 'desktop');
    $embed_code = EmbedConverter::convertUrl($block->input('source_url'))
@endphp

@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', [
        'type' => 'embed',
        'size' => 'm',
        'media' => [
            "embed" => $embed_code,
            "src" => $image['src'],
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

