@php
    $ids = $block->browserIds('artworks');
    $artwork = \App\Models\Api\Artwork::query()->ids($ids)->get()->first();
    if ($artwork) {
        $image = $artwork->imageFront('hero', 'thumbnail');

        $galleryLocation = '';
        if ($artwork->is_on_view) {
            $galleryLocation = '';
            if (!empty($item->collection_status)) {
                $galleryLocation .= $item->collection_status . ', ';
            }
            if (!empty($item->gallery_title)) {
                $galleryLocation .= $item->gallery_title;
            }
        }

        $caption = "";
        if (!empty($artwork->artist_title)) {
            $caption = $artwork->artist_title;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->place_of_origin;
        }

        if (!empty($artwork->date_block)) {
            $caption .= ', ' . $artwork->date_block;
        }

        $artworkItem = array();
        $artworkItem['type'] = 'image';
        $artworkItem['size'] = 's';
        $artworkItem['media'] = $image;
        $artworkItem['captionTitle'] = $artwork->title;
        $artworkItem['caption'] = $caption.'<br>'.$galleryLocation;
        $artworkItem['hideShare'] = true;
        $artworkItem['fullscreen'] = true;
        $artworkItem['urlTitle'] = route('artworks.show', $artwork);
        $artworkItem['isArtwork'] = true;
        $artworkItem['isZoomable'] = $artwork->is_zoomable;
        $artworkItem['isPublicDomain'] = $artwork->is_public_domain;
        $artworkItem['maxZoomWindowSize'] = $artwork->max_zoom_window_size;
    }
@endphp
@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', $artworkItem)
@endcomponent
