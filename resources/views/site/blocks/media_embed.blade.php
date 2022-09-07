@php
    $embed_type = $block->input('embed_type');
    $embed_code = $block->input('embed_code');
    $embed_url = $block->input('embed_url');
    $embed_height = $block->input('embed_height');
    $disablePlaceholder = $block->input('disable_placeholder');
    if ($embed_type == 'url') {
        $embed_code = EmbedConverter::convertUrl($embed_url);
    }
@endphp

@if ($embed_type == 'html' && $embed_code)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('embed_height', $embed_height)
        @slot('item', [
            'type' => 'embed',
            'size' => $block->input('size'),
            'disablePlaceholder' => $disablePlaceholder,
            'media' => [
                "embed" => $embed_code,
                "src" => (isset($image['src'])) ? $image['src'] : '',
                "srcset" => (isset($image['src'])) ? $image['src'] : '',
                "width" => (isset($image['width'])) ? $image['width'] : '',
                "height" => (isset($image['height'])) ? $image['height'] : '',
                "shareUrl" => '#',
                "shareTitle" => '',
                "downloadUrl" => '',
                "downloadName" => '',
                "credit" => '',
                "creditUrl" => '',
            ],
            'caption' => '',
        ])
    @endcomponent
@elseif ($embed_type == 'url' && $embed_url)
    @component('components.molecules._m-media')
        {{-- variation 'o-blocks__block' ONLY for inline in article pages and NOT for inside of galleries or anywhere else --}}
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'embed',
            'size' => $block->input('size'),
            'media' => ['embed' => $embed_code],
        ])
    @endcomponent
@endif
