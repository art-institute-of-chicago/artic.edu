@php
    $captionTitle = $block->present()->input('caption_title');
    $captionText = $block->present()->input('caption');
    $size = $block->present()->input('size');

    $images = [];
    $annotations = [];

    foreach ($block->childs as $child) {
        $mediaItem = [
            'media' => $child->imageAsArray('image', 'desktop'),
            'label' => $child->input('label'),
        ];

        if ($child['type'] == 'layered_image_viewer_img') {
            $images[] = $mediaItem;
        }

        if ($child['type'] == 'layered_image_viewer_annotation') {
            $annotations[] = $mediaItem;
        }
    }
@endphp

@if (count($images) > 0 || count($annotations) > 0)
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('captionTitle', $captionTitle)
        @slot('captionText', $captionText)
        @slot('size', $size)
        @slot('images', $images)
        @slot('annotations', $annotations)
    @endcomponent
@endif
