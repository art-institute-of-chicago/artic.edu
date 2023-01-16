@php
    $captionTitle = $block->present()->input('caption_title');
    $caption = $block->present()->input('caption');

    $images = [];
    $annotations = [];

    foreach ($block->childs as $child) {
        if ($child['type'] == 'layered_image_viewer_img') {
            $mediaImage = [
                'type' => 'image',
                'size' => $block->input('size'),
                'media' => $child->imageAsArray('image', 'desktop'),
                'label' => $child->input('label'),
            ];

            $images[] = $mediaImage;
        }

        if ($child['type'] == 'layered_image_viewer_annotation') {
            $mediaAnnotation = [
                'type' => 'image',
                'size' => $block->input('size'),
                'media' => $child->imageAsArray('image', 'desktop'),
                'label' => $child->input('label'),
            ];

            $annotations[] = $mediaAnnotation;
        }
    }

@endphp

@if (count($images) > 0)
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('captionTitle', $captionTitle)
        @slot('caption', $caption)
        @slot('images', $images)
        @slot('annotations', $annotations)
        @slot('imageSettings', $imageSettings ?? array(
                'srcset' => array(200,400,600,1000,1500,3000),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '28',
                    'medium' => '28',
                    'large' => '28',
                    'xlarge' => '21',
                )),
            ))
    @endcomponent
@endif
