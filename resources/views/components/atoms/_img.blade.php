@php
    $highlight = ' ';
    if (!isset($image['sourceType']) || empty($image['sourceType'])) {
        $image['sourceType'] = 'imgix';
    }

    if (isset($settings)) {
        $settings = aic_imageSettings(array(
            'settings' => $settings,
            'image' => $image,
        ));

        $srcset = $settings['srcset'];
        $sizes = $settings['sizes'];
        $src = $settings['src'];
        $width = $settings['width'];
        $height = $settings['height'];
    }

    if (empty($src)) {
        $src = $image['src'];
        $highlight = ' data-no-img-settings';
    }

    if (empty($width)) {
        $width = $image['width'];
    }

    if (empty($height)) {
        $height = $image['height'];
    }
@endphp
<img
    alt="{{ $image['alt'] ?? '' }}{{ $alt ?? '' }}"
    class="{{ $image['class'] ?? '' }} {{ $class ?? '' }}"
    src="{{ $src ?? '' }}"
    srcset="{{ $srcset ?? '' }}"
    sizes="{{ $sizes ?? '' }}"
    width="{{ $width ?? '' }}"
    height="{{ $height ?? '' }}"
    {{ $highlight }}
>
