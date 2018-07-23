@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';
    $ids = $block->browserIds('artworks');
    $artworks = \App\Models\Api\Artwork::query()->ids($ids)->get();

    $items = [];
    foreach($artworks as $artwork) {
        $image = $artwork->imageFront('hero', 'thumbnail');

        $caption = "";
        if (!empty($artwork->artist_title)) {
            $caption = $artwork->artist_title;
        } else if (!empty($artwork->place_of_origin)) {
            $caption = $artwork->place_of_origin;
        }

        if (!empty($artwork->date_block)) {
            $caption .= ', ' . $artwork->date_block;
        }

        $item = [];
        $item['type'] = 'image';
        $item['fullscreen'] = true;
        $item['size'] = 'gallery';
        $item['media'] = $image;
        $item['captionTitle'] = $artwork->title;
        $item['caption'] = $caption;
        $item['url'] = route('artworks.show', $artwork);
        $item['urlTitle'] = route('artworks.show', $artwork);
        $item['showUrl'] = true;
        $item['isArtwork'] = true;
        $item['isZoomable'] = $artwork->is_zoomable;
        $item['isPublicDomain'] = $artwork->is_public_domain;
        $item['maxZoomWindowSize'] = $artwork->max_zoom_window_size;
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @if ($subtype === 'mosaic')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '28',
                  'medium' => '28',
                  'large' => '28',
                  'xlarge' => '21',
            )),
        ))
    @endif
    @if ($subtype === 'slider')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '50',
                  'small' => '35',
                  'medium' => '23',
                  'large' => '23',
                  'xlarge' => '18',
            )),
        ))
    @endif

    @slot('variation', 'o-blocks__block')
    @slot('title', $block->input('title'))
    @slot('caption', $block->input('subhead'))
    @slot('items', $items)
@endcomponent
