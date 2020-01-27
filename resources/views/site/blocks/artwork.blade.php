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

        $title = $artwork->present()->listingTitle;
        $title = getTitleWithFigureNumber($title);

        $caption = "";
        if (!empty($artwork->artist_title)) {
            $caption = $artwork->present()->artist_title;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->present()->place_of_origin;
        }

        $artworkItem = array();
        $artworkItem['type'] = 'image';
        $artworkItem['size'] = 's';
        $artworkItem['media'] = $image;
        $artworkItem['captionTitle'] = $title;
        $artworkItem['caption'] = $caption.'<br>'.$galleryLocation;
        $artworkItem['hideShare'] = true;
        $artworkItem['fullscreen'] = true;
        $artworkItem['urlTitle'] = route('artworks.show', $artwork);
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
