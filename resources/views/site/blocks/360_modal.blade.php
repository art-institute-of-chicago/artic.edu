@php
    $image = $block->imageAsArray('image', 'desktop');
    $caption = $block->input('caption');
    $caption_title = $block->input('caption_title');
    $image_sequence_file = $block->assetLibrary;
@endphp

@if ($image_sequence_file)
    <script type='application/json' id='assetLibrary'>
        {!! json_encode($block->assetLibrary) !!}
    </script>

    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'module360',
            'media' => [
                'src' => $image['src'],
                'srcset' => $image['src'],
                'width' => $image['width'] ?? 0,
                'height' => $image['height'] ?? 0,
                'alt' => $image['alt'],
                'title' => isset($pageTitle) ? $pageTitle : ''
            ],
            'poster' => $image,
            'figureNumber' => $figureNumber = getFigureNumber(),
            'captionTitle' => getTitleWithFigureNumber($caption_title, $figureNumber),
            'caption' => getSubtitleWithFigureNumber($caption, $caption_title, $figureNumber),
        ])
    @endcomponent
@endif
