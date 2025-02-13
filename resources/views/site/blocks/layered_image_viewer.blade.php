@php
    $captionTitle = $block->present()->input('caption_title');
    $captionText = $block->present()->input('caption');
    $size = $block->present()->input('size');
    $images = [];
    $overlays = [];
    $cropRegion = null;

    $firstImage = $block->children->filter(function ($item) {
        return $item->type == 'layered_image_viewer_img';
    })->first();

    // Pull the crop from the first image to pass to the organism
    if ($firstImage) {
        $cropRegion = array_intersect_key(
            $firstImage->imageAsArray('image', 'desktop'),
            array_flip(['crop_x', 'crop_y', 'width', 'height'])
        );
        $cropRegion['x'] = $cropRegion['crop_x'];
        $cropRegion['y'] = $cropRegion['crop_y'];
        unset($cropRegion['crop_x']);
        unset($cropRegion['crop_y']);
        $cropRegion = htmlspecialchars(json_encode($cropRegion), ENT_QUOTES, 'UTF-8');
    }

    foreach ($block->children as $child) {
        $mediaItem = [
            'media' => $child->imageAsArray('image', 'desktop'),
            'label' => $child->input('label'),
            'starting_view' => $child->checkbox('starting_view') ? $child->checkbox('starting_view') : false,
        ];

        // Append full source for viewer
        $mediaItem['media']['full_src'] = strtok($mediaItem['media']['src'], '?');

        if ($child['type'] == 'layered_image_viewer_img') {
            $images[] = $mediaItem;
        }

        if ($child['type'] == 'layered_image_viewer_overlay') {
            $overlays[] = $mediaItem;
        }

    }
@endphp

@if (count($images) > 0 || count($overlays) > 0)
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('captionTitle', $captionTitle)
        @slot('captionText', $captionText)
        @slot('size', $size)
        @slot('images', $images)
        @slot('overlays', $overlays)
        @slot('cropRegion', $cropRegion)
    @endcomponent
@endif
