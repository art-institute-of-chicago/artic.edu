@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';

    $items = [];
    foreach ($block->childs as $item) {
        $item->type = 'image';
        $item->size = 'gallery';
        $item->fullscreen = true;
        $item->media = $item->imageAsArray('image', 'desktop');
        $item->captionTitle = $item->present()->input('captionTitle');
        $item->caption = $item->present()->input('caption');
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
