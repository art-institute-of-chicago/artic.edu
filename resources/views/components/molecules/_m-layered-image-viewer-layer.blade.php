@php
    $layerType = isset($layerType) ? $layerType : 'image';
    $size = isset($size) ? $size : 'm';
    $media = $item['media'];
    $width = $item['media']['width'];
    $height = $item['media']['height'];
    $crop_x = $item['media']['crop_x'];
    $crop_y = $item['media']['crop_y'];

    $defaultSrcset = array(300,600,800,1200,1600,2000,3000,4500);

    if (empty($imageSettings) && $size === 's') {
        $imageSettings = array(
            'srcset' => $defaultSrcset,
            'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '58',
                    'medium' => '38',
                    'large' => '28',
                    'xlarge' => '28',
        )));
    }

    if (empty($imageSettings) && $size === 'm') {
        $imageSettings = array(
            'srcset' => $defaultSrcset,
            'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '58',
                    'medium' => '58',
                    'large' => '43',
                    'xlarge' => '43',
        )));
    }

    if (empty($imageSettings) && $size === 'l') {
        $imageSettings = array(
            'srcset' => $defaultSrcset,
            'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '58',
                    'medium' => '58',
                    'large' => '58',
                    'xlarge' => '58',
        )));
    }

    global $_allowAdvancedModalFeatures;
@endphp

<figure class="m-media m-media--{{ (isset($size)) ? $size : 'm' }} m-media--contain">
    <div class="m-media__img" data-behavior="fitText">
        <div
            class="m-media__contain--spacer"
            style="padding-bottom: 62.5%"
        ></div>
        <img
            {{-- Image (small, medium or large) --}}
            src="{{ $media['src'] }}"
            alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."

            @if ($layerType == 'image')
                width="2000"
                height="2614"
            @endif

            {{-- Todo: Important to include this, must be largest size available: --}}
            data-viewer-src="{{ $media['src'] }}"
        />
    </div>
    @if (isset($item['label']))
        <figcaption>
            <div class="f-caption">
                {!! $item['label'] !!}
            </div>
        </figcaption>
    @endif
</figure>
