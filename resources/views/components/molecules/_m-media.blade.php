@php
    $type = isset($item['type']) ? $item['type'] : 'video';
    $size = isset($item['size']) ? $item['size'] : 's';
    $media = $item['media'];
    $tag = (isset($item['url']) && $item['url'] && $type !== 'embed' && $type !== 'video') ? 'a' : 'span';

    if (empty($imageSettings) && $size === 's') {
        $imageSettings = array(
            'srcset' => array(300,600,800,1200,1600),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '58',
                  'medium' => '38',
                  'large' => '28',
                  'xlarge' => '28',
        )));
    }

    if (empty($imageSettings) && $size === 'm') {
        $imageSettings = array(
            'srcset' => array(300,600,800,1200,1600,2000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '58',
                  'medium' => '58',
                  'large' => '58',
                  'xlarge' => '43',
        )));
    }

    if (empty($imageSettings) && $size === 'l') {
        $imageSettings = array(
            'srcset' => array(300,600,800,1200,1600,2000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '58',
                  'medium' => '58',
                  'large' => '58',
                  'xlarge' => '58',
        )));
    }

    if ($type == 'embed') {
        // make embeds lazy load
        $media['embed'] = preg_replace('/src/i', 'data-src', $media['embed']);
        // fix soundcloud embed height
        if (strrpos($media['embed'],'api.soundcloud.com')) {
            $media['embed'] = preg_replace_callback('/(height=")([^"]*)/i', function($m) { return $m[1].'166'; },$media['embed']);
            $variation = ($variation ?? '').' m-media--soundcloud';
        }
    }
@endphp
<figure data-type="{{ $type }}" class="m-media m-media--{{ $size }}{{ (isset($item['variation'])) ? ' '.$item['variation'] : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <{{ $tag }}{!! ($tag === 'a') ? ' href="'.$item['url'].'"' : '' !!} class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : '' }}"{!! (isset($item['fullscreen']) and $item['fullscreen'] and $tag !== 'a') ? ' data-behavior="openImageFullScreen"' : '' !!}>
        @if ($type == 'image')
            @component('components.atoms._img')
                @slot('image', $media)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @elseif ($type == 'embed')
            {!! $media['embed'] ?? '' !!}
        @else
            @component('components.atoms._video')
                @slot('video', $media)
                @if ($size === 'hero')
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @else
                    @slot('controls', true)
                @endif
            @endcomponent
        @endif
        @if (isset($item['downloadable']) and $item['downloadable'] && $tag !== 'a')
            @component('components.atoms._btn')
                @slot('variation', 'btn--septenary btn--icon btn--icon-circle-48 m-media__btn-download')
                @slot('font', '')
                @slot('icon', 'icon--download--24')
                @slot('tag', 'a')
                @slot('href', $media['downloadUrl'])
                @slot('download', true)
            @endcomponent
        @endif
        @if (isset($item['fullscreen']) and $item['fullscreen'])
            @component('components.atoms._btn')
                @slot('variation', 'm-media__btn-fullscreen btn--septenary btn--icon btn--icon-circle-48')
                @slot('font', '')
                @slot('icon', 'icon--zoom--24')
                @if ($tag === 'a')
                    @slot('behavior','openImageFullScreen')
                @endif
            @endcomponent
        @endif
    </{{ $tag }}>
    @if (!isset($item['hideCaption']) or (isset($item['hideCaption']) and !$item['hideCaption']))
    <figcaption>
        @if ($size == 'gallery')
            @if (isset($item['captionTitle']))<strong class="f-caption">{!! $item['captionTitle'] !!}</strong> <br>@endif
            @if (isset($item['caption']))<span class="f-caption">{!! $item['caption'] !!}</span>@endif
        @else
            @if (isset($item['captionTitle']))<strong class="f-caption-title">{!! $item['captionTitle'] !!}</strong> <br>@endif
            @if (isset($item['caption']))<span class="f-caption">{!! $item['caption'] !!}</span>@endif
            @if (!isset($item['hideShare']))
            @component('components.atoms._btn')
                @slot('variation', 'btn--quinary btn--icon m-media__share')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
                @slot('behavior','sharePage')
            @endcomponent
            @endif
        @endif
    </figcaption>
    @endif
</figure>
