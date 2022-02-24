@php
    $media_type = $block->input('media_type', 'youtube');
    $loop_or_once = $block->input('loop_or_once', 'loop');
    $source_url = $block->input('url');
    $image = $block->imageAsArray('image', 'desktop');
    $embed_code = EmbedConverter::convertUrl($source_url);
    $size = $block->input('size', 'm');
    $captionTitle = $block->present()->input('caption_title');
    $caption = $block->present()->input('caption');
    $platform = 'youtube';
    if (strpos($source_url, 'vimeo.com/') !== false) {
        $platform = 'vimeo';
    }
@endphp

@if ($media_type == 'loop')
    @component('components.molecules._m-media')
        {{-- variation 'o-blocks__block' ONLY for inline in article pages and NOT for inside of galleries or anywhere else --}}
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'video',
            'size' => $size,
            'media' => $image,
            'captionTitle' => $captionTitle,
            'caption' => $caption,
            'platform' => $platform,
            'loop' => true,
            'loop_or_once' => $loop_or_once,
            'useAltBackground' => $block->input('use_alt_background'),
        ])
    @endcomponent
@else
    @if ($source_url)
        @component('components.molecules._m-media')
            {{-- variation 'o-blocks__block' ONLY for inline in article pages and NOT for inside of galleries or anywhere else --}}
            @slot('variation', 'o-blocks__block')
            @slot('item', [
                'type' => 'embed',
                'size' => $size,
                'media' => ['embed' => $embed_code],
                'poster' => $image,
                'captionTitle' => $captionTitle,
                'caption' => $caption,
                'platform' => $platform,
            ])
        @endcomponent
    @endif
@endif
