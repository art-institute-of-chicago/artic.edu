@php
    $layerType = isset($layerType) ? $layerType : 'image';
    $size = isset($size) ? $size : 'm';
    $media = $item['media'];
    $alt = $item['media']['alt'];
    $width = $item['media']['width'];
    $height = $item['media']['height'];
    $crop_x = $item['media']['crop_x'];
    $crop_y = $item['media']['crop_y'];
    $startingView = $item['starting_view'] ? $item['starting_view'] : false;

    // Set empty $imageSettings, this will be populated based on $size
    $imageSettings = [];

    $defaultSrcset = array(200,400,600,1000,1500,3000);

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

    if (isset($imageSettings)) {

        $imageSettings = ImageHelpers::aic_imageSettings(array(
            'settings' => $imageSettings,
            'image' => $media,
        ));

        $srcset = $imageSettings['srcset'];
        $sizes = $imageSettings['sizes'];
    }

    global $_allowAdvancedModalFeatures;
@endphp

<figure class="m-media m-media--{{ (isset($size)) ? $size : 'm' }} m-media--layered-image-viewer-embed m-media--contain">
    <div class="m-media__img" data-behavior="fitText">
        @if ($size === 'm' || $size === 'l')
            <div
                class="m-media__contain--spacer"
                style="padding-bottom: {{ min(62.5, intval($media['height'] ?? 10) / intval($media['width'] ?? 16) * 100) }}%"
            ></div>
        @endif
        <img
            src="{{ $media['src'] }}"
            alt="{{ $alt }}"

            @if ($layerType == 'image')
                width="{{ $width }}"
                height="{{ $height }}"

                {{-- srcset only applied to image as overlay will be svg --}}
                srcset="{{ $srcset ?? '' }}"
                sizes="{{ $sizes ?? '' }}"
            @endif

            {{-- Important to include this, must be largest size available: --}}
            data-viewer-src="{{ $media['full_src'] }}"
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
