@php
    if (isset($image_id)) {
        $src = LakeviewImageService::getUrl($image_id);
    }
@endphp
<img alt="{{ $alt ?? '' }}" class="{{ $class ?? '' }}" src="{{ $src ?? '' }}" sizes="{{ $sizes ?? '' }}" srcset="{{ $srcset ?? '' }}" width="{{ $width ?? '' }}" height="{{ $height ?? '' }}">
