@php
    $captionTitle = $block->present()->input('caption_title');
    $caption = $block->present()->input('caption');

    $images = [];
    $annotations = [];

    foreach ($block->childs as $child) {
        $mediaItem = [
            'type' => 'image',
            'size' => $block->input('size'),
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
        @slot('caption', $caption)
        @slot('images', $images)
        @slot('annotations', $annotations)
        @slot('imageSettings', $imageSettings ?? array(
                'srcset' => array(300,600,800,1200,1600,2000,3000,4500),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '58',
                    'medium' => '58',
                    'large' => '43',
                    'xlarge' => '43',
                )),
            ))
    @endcomponent
@endif
