@php
    $source_url = $block->input('url');
    $image = $block->imageAsArray('image', 'desktop');
    $embed_code = EmbedConverter::convertUrl($source_url);
    $size = $block->input('size', 'm');
    $captionTitle = $block->present()->input('caption_title');
    $caption = $block->present()->input('caption');
@endphp

@if ($source_url)
    @component('components.molecules._m-media')
        {{-- variation 'o-blocks__block' ONLY for inline in article pages and NOT for inside of galleries or anywhere else --}}
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'embed',
            'size' => $size,
            'media' => ['embed' => $embed_code],
            'poster' => $image,
            'captionTitle' => getTitleWithFigureNumber($captionTitle),
            'caption' => getSubtitleWithFigureNumber($caption, $captionTitle),
        ])
    @endcomponent
@endif
