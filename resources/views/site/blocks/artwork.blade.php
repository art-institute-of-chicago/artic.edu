@php
    $ids = $block->browserIds('artworks');

    if (!empty($ids)) {
        $artwork = \App\Models\Api\Artwork::query()->ids($ids)->get()->first();
    }

    if (isset($artwork)) {
        $image = $artwork->imageFront('hero', 'thumbnail');

        $galleryLocation = '';
        if ($artwork->is_on_view) {
            $galleryLocation = '';
            if (!empty($item->collection_status)) {
                $galleryLocation .= $item->collection_status . ', ';
            }
            if (!empty($item->gallery_title)) {
                $galleryLocation .= $item->present()->gallery_title;
            }
        }

        $caption = "";
        if (!empty($artwork->artist_title)) {
            $caption = $artwork->present()->artist_title;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->present()->place_of_origin;
        }

        $captionAddendum = '';
        if (!empty($block->input('captionAddendum'))) {
            $captionAddendum .= $block->input('captionAddendum');
        }

        $urlTitle = route('artworks.show', $artwork);

        $artworkItem = array();
        $artworkItem['type'] = 'image';
        $artworkItem['size'] = 's';
        $artworkItem['media'] = $image;
        $artworkItem['captionTitle'] = $artwork->present()->listingTitle;
        $artworkItem['caption'] = $caption.'<br>'.$galleryLocation.($captionAddendum ? '<br>'.$captionAddendum : '');
        $artworkItem['fullscreen'] = true;
        $artworkItem['urlTitle'] = isset($figureNumber) ? null : $urlTitle;
        $artworkItem['showUrl'] = true;
        $artworkItem['isArtwork'] = true;
        $artworkItem['isZoomable'] = $artwork->is_zoomable;
        $artworkItem['isPublicDomain'] = $artwork->is_public_domain;
        $artworkItem['maxZoomWindowSize'] = $artwork->max_zoom_window_size;
    }
@endphp
@if(isset($artworkItem))
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', $artworkItem)
    @endcomponent
@endif
