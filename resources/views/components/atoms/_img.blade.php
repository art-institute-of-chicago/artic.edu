@php
    if (isset($image_id)) {
        $src = LakeviewImageService::getUrl($image_id);
    }
@endphp
<img
    alt="{{ $image['alt'] ?? '' }}{{ $alt ?? '' }}"
    class="{{ $image['class'] ?? '' }} {{ $class ?? '' }}"
    src="{{ $image['src'] ?? '' }}"
    srcset="{{ $image['srcset'] ?? '' }}"
    width="{{ $image['width'] ?? '' }}"
    height="{{ $image['height'] ?? '' }}"
    sizes="{{ $sizes ?? '' }}"
>
