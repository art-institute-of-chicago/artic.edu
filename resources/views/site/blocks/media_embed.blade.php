@php
    $source_url = $block->input('source_url');
    $image = $block->imageAsArray('image', 'desktop');
    $embed_code = EmbedConverter::convertUrl($source_url);
@endphp

@if ($source_url)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'embed',
            'size' => 'm',
            'media' => [
                "embed" => $embed_code,
                "src" => (isset($image['src'])) ? $image['src'] : '',
                "srcset" => (isset($image['src'])) ? $image['src'] : '',
                "width" => (isset($image['width'])) ? $image['width'] : '',
                "height" => (isset($image['height'])) ? $image['height'] : '',
                "shareUrl" => '#',
                "shareTitle" => '',
                "downloadUrl" => $source_url,
                "downloadName" => '',
                "credit" => '',
                "creditUrl" => '',
            ],
            'caption' => ''
        ])
    @endcomponent
@endif
