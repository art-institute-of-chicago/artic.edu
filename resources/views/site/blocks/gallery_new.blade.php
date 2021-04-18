@php
    switch ($block->input('layout')) {
        case 1:
            $subtype = 'mosaic';
            break;
        case 2:
            $subtype = 'slider';
            break;
        case 3:
            $subtype = 'small-mosaic';
            break;
        default:
            $subtype = 'slider';
            break;
    }

    // Preload all artworks ahead of time
    $ids = $block->childs
        ->filter(function($item) {
            return $item->input('gallery_item_type') === \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK;
        })
        ->map(function($item) {
            return $item->browserIds('artworks');
        })
        ->map(function($ids) {
            return $ids[0] ?? null;
        })
        ->filter()
        ->values()
        ->all();

    if (count($ids) > 0) {
        $artworks = \App\Models\Api\Artwork::query()->ids($ids)->get();
    } else {
        $artworks = collect([]);
    }

    $items = [];

    foreach ($block->childs as $item) {
        switch ($item->input('gallery_item_type')) {
            case \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM:
                $title = $item->present()->input('captionTitle');
                $subtitle = $item->present()->input('captionText');

                $mediaItem = [
                    'type' => 'image',
                    'size' => 'gallery',
                    'fullscreen' => true,
                    'media' => $item->imageAsArray('image', 'desktop'),
                    'figureNumber' => $figureNumber = getFigureNumber(),
                    'captionTitle' => getTitleWithFigureNumber($title, $figureNumber),
                    'caption' => getSubtitleWithFigureNumber($subtitle, $title, $figureNumber),
                    'videoUrl' => $item->input('videoUrl'),
                ];

                if (($block->input('is_gallery_zoomable') ?? false) || $item->input('is_zoomable')) {
                    if (isset($mediaItem['media'])) {
                        $mediaItem['media']['iiifId'] = $item->getImgixTileSource('image', 'desktop');
                    }

                    // PUB-34: Unexpected, but these settings don't seem to matter at all
                    // $mediaItem = array_merge($mediaItem, [
                    //     'isZoomable' => true,
                    //     'maxZoomWindowSize' => -1,
                    //     'isArtwork' => true,
                    // ]);
                }

                $items[] = $mediaItem;

                break;
            case \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK:
                $ids = $item->browserIds('artworks');

                if (!$ids) {
                    break;
                }

                $artwork = $artworks->where('id', '=', $ids[0])->first();

                if (!$artwork) {
                    break;
                }

                $image = $artwork->imageFront('hero', 'thumbnail');
                $title = $artwork->present()->listingTitle;

                $caption = '';

                if (!empty($artwork->artist_title)) {
                    $caption = '<p>' . $artwork->present()->artist_title . '</p>';
                } else if (!empty($artwork->place_of_origin)) {
                    $caption = '<p>' . $artwork->present()->place_of_origin . '</p>';
                }

                if (!empty($item->input('captionAddendum'))) {
                    $caption .= $item->input('captionAddendum');
                }

                $urlTitle = route('artworks.show', $artwork);

                $items[] = [
                  'type' => 'image',
                  'fullscreen' => true,
                  'size' => 'gallery',
                  'media' => $image,
                  'figureNumber' => $figureNumber = getFigureNumber(),
                  'captionTitle' => getTitleWithFigureNumber($title, $figureNumber, $urlTitle),
                  'caption' => getSubtitleWithFigureNumber($caption, $title, $figureNumber),
                  'url' => route('artworks.show', $artwork),
                  'urlTitle' => isset($figureNumber) ? null : $urlTitle,
                  'showUrl' => true,
                  'isArtwork' => true,
                  'isZoomable' => $artwork->is_zoomable,
                  'isPublicDomain' => $artwork->is_public_domain,
                  'maxZoomWindowSize' => $artwork->max_zoom_window_size,
                ];
                break;
        }
    }
@endphp

@if (count($items) > 0)
    @component('components.organisms._o-gallery----'.$subtype)
        @slot('variation', 'o-blocks__block o-gallery----theme-' . ($block->input('theme') ?? 'dark'))
        @slot('title', $block->present()->input('title'))
        @slot('caption', $block->present()->input('description'))
        @slot('allLink', null);
        @slot('items', $items)
    @endcomponent
@endif
