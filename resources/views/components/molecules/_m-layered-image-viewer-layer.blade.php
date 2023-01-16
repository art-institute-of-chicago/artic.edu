@php
    $type = isset($item['type']) ? $item['type'] : 'image';
    $size = isset($item['size']) ? $item['size'] : 's';
    $media = $item['media'];

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

<figure data-type="{{ $type }}" data-title="{{ $media['caption'] ?? (isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '') }}" class="m-media m-media--{{ $size }}">
    <div class="m-media__img" data-behavior="fitText" {!! ($_allowAdvancedModalFeatures ?? false) ? ' data-modal-advanced="true"' : '' !!}{!! isset($media['restrict']) && $media['restrict'] ? ' data-restrict="true"' : '' !!}{!! isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '' !!}>
        @if ($type == 'image')
            @component('components.atoms._img')
                @slot('image', $media)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
    </div>
    <figcaption>
        @if (isset($item['label']))
            <div class="f-caption">{!! $item['label'] !!}</div>
        @endif
    </figcaption>
</figure>
