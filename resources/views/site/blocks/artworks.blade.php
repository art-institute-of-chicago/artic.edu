@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';
    $ids = $block->browserIds('artworks');
    $artworks = \App\Models\Api\Artwork::query()->ids($ids)->get();

    $items = [];
    foreach($artworks as $artwork) {
        $image = $artwork->imageFront('hero', 'thumbnail');

        $caption = "";
        if (!empty($artwork->artist_display)) {
            $caption = $artwork->artist_display;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->place_of_origin;
        }

        if (!empty($artwork->date_display)) {
            $caption .= ', ' . $artwork->date_display;
        }

        $item = [];
        $item['type'] = 'image';
        $item['media'] = $image;
        $item['captionTitle'] = $artwork->title;
        $item['caption'] = $caption;
        $item['url'] = route('artworks.show', $artwork);
        $item['urlTitle'] = route('artworks.show', $artwork);
        $items[] = $item;

    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @slot('variation', 'o-blocks__block')
    @slot('title', $block->input('title'))
    @slot('caption', $block->input('subhead'))
    @slot('items', $items)
@endcomponent
