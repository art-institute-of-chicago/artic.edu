@php
    $source_url = $block->input('url');
    $image = $block->imageAsArray('image', 'desktop');
    $embed_code = EmbedConverter::convertUrl($source_url);
    $size = $block->input('size', 'm');
    $captionTitle = $block->input('caption_title');
    $caption = $block->input('caption');
@endphp

@if ($source_url)
    @component('components.molecules._m-media')
        @slot('item', [
            'type' => 'embed',
            'size' => $size,
            'media' => ['embed' => $embed_code],
            'poster' => $image,
            'captionTitle' => $captionTitle,
            'caption' => $caption
        ])
    @endcomponent
@endif
