@php
    $ids = $block->browserIds('artworks');
    $artwork = \App\Models\Api\Artwork::query()->ids($ids)->get()->first();
    if ($artwork) {

        $image = null;
        if ($artwork->image_id) {
            $image = LakeviewImageService::getImage($artwork->image_id);
        }

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
        if (!empty($artwork->artist_display)) {
            $caption = $artwork->artist_display;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->place_of_origin;
        }

        if (!empty($artwork->date_display)) {
            $caption .= ', ' . $artwork->date_display;
        }

        $artworkItem = array();
        $artworkItem['type'] = 'image';
        $artworkItem['media'] = $image;
        $artworkItem['captionTitle'] = $artwork->title;
        $artworkItem['caption'] = $caption.'<br>'.$galleryLocation;
        $artworkItem['hideShare'] = true;
        $artworkItem['fullscreen'] = true;
    }
@endphp
@component('components.molecules._m-media')
    @slot('variation', 'o-blocks__block')
    @slot('item', $artworkItem)
@endcomponent
