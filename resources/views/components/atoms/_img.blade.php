@php
    if (isset($image_id)) {
        $src = LakeviewImageService::getUrl($image_id);
    }

    if (isset($srcset)) {
        $srcsetAndSource = aic_imageSrcSet(array(
            'srcset' => $srcset,
            'image' => $image,
        ));

        $srcset = $srcsetAndSource['srcset'];
        $src = $srcsetAndSource['src'];
    }

    if (empty($src)) {
        $src = $image['src'];
    }
@endphp
<img
    width="{{ $image['width'] ?? '' }}"
    height="{{ $image['height'] ?? '' }}"
    alt="{{ $image['alt'] ?? '' }}{{ $alt ?? '' }}"
    class="{{ $image['class'] ?? '' }} {{ $class ?? '' }}"
    src="{{ $src ?? '' }}"
    srcset="{{ $srcset ?? '' }}"
    sizes="{{ $sizes ?? '' }}"
>
