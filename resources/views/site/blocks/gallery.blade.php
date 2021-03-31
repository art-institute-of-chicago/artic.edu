@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';

    $items = [];
    foreach ($block->childs as $item) {
        $title = $item->present()->input('captionTitle');
        $subtitle = $item->present()->input('caption');

        $item->type = 'image';
        $item->size = 'gallery';
        $item->fullscreen = true;
        $item->media = $item->imageAsArray('image', 'desktop');
        $item->figureNumber = $figureNumber = getFigureNumber();
        $item->captionTitle = getTitleWithFigureNumber($title, $figureNumber);
        $item->caption = getSubtitleWithFigureNumber($subtitle, $title, $figureNumber);
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @slot('variation', 'o-blocks__block o-gallery----theme-' . ($block->input('theme') ?? 'dark'))
    @slot('title', $block->present()->input('title'))
    @slot('caption', $block->present()->input('description'))
    @slot('allLink', null);
    @slot('items', $items)
@endcomponent
