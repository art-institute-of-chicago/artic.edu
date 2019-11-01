@php

    $type = isset($item['type']) ? $item['type'] : 'video';
    $size = isset($item['size']) ? $item['size'] : 's';
    $media = $item['media'];
    $fullscreen = (isset($item['fullscreen']) && $item['fullscreen']) && (!isset($media['restrict']) || !$media['restrict']);
    $poster = isset($item['poster']) ? $item['poster'] : false;

    // WEB-912: For Gallery Items; image module is an array, but gallery item is object?
    if (!is_array($item) && !empty($item->present()->input('videoUrl')))
    {
        $type = 'embed';
        $poster = $media;
        $media['embed'] = \App\Facades\EmbedConverterFacade::convertUrl($item->present()->input('videoUrl'));
    }

    if ($type === 'embed' and strrpos($media['embed'],'api.soundcloud.com')) {
        $size = 's';
    }

    $defaultSrcset = array(300,600,800,1200,1600,2000,3000,4500);

    if ($item['isArtwork'] ?? false) {
        $defaultSrcset = ($item['isPublicDomain'] ?? false) ? array(200,400,600,800,1200,1600) : array(200,400,600,800);
    }

    if (empty($imageSettings) && $size === 's') {
        $imageSettings = array(
            'srcset' => $defaultSrcset,
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
            'srcset' => $defaultSrcset,
            'sizes' => aic_imageSizes(array(
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
        if (!$poster) {
            $fullscreen = false;
        }
        if (!$fullscreen and !$poster) {
            $media['embed'] = preg_replace('/src/i', 'data-src', $media['embed']);
        }
        if (!$fullscreen and $poster) {
            $media['embed'] = preg_replace('/src/i', 'data-embed-src', $media['embed']);
        }
        $imageSettings['ratio'] = '16:9';

        // Allow soundcloud embed to expand in height - see _m-media.scss
        if (strrpos($media['embed'],'api.soundcloud.com'))
        {
            $variation = ($variation ?? '').' m-media--soundcloud';
            $imageSettings['ratio'] = '9:2';
        }
    }

    $mediaBehavior = false;
    if ($fullscreen and $type !== 'embed') {
      $mediaBehavior = 'openImageFullScreen';
    }
    if ($fullscreen and $type == 'module3d') {
      $mediaBehavior = 'triggerMediaModal';
    }
    if ($fullscreen and $type == 'embed') {
      $mediaBehavior = 'triggerMediaModal';
    }
    if (!$fullscreen and $type == 'embed') {
      $mediaBehavior = 'triggerMediaInline';
    }

    if ($item['showUrl'] ?? false) {
        $imageSettings['infoUrl'] = $item['urlTitle'];
    }

    $showUrlFullscreen = $item['showUrl'] ?? false && $item['showUrlFullscreen']  ?? false && $item['urlTitle'] ?? null;

    if (isset($item['isArtwork'])) {
        $variation = ($variation ?? '').' m-media--artwork';
        $isZoomable = $item['isZoomable'] ?? false;
        $maxZoomWindowSize = $item['maxZoomWindowSize'] ?? 843;
        $maxZoomWindowSize = ($maxZoomWindowSize === -1) ? 1280 : $maxZoomWindowSize;
        if (!$isZoomable or $maxZoomWindowSize < 1280) {
            $mediaBehavior = '';
            $fullscreen = false;
        }
    }
@endphp
<{{ $tag ?? 'figure' }} data-type="{{ $type }}" class="m-media m-media--{{ $size }}{{ (isset($item['variation'])) ? ' '.$item['variation'] : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <span class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : '' }}"{!! ($mediaBehavior) ? ' data-behavior="'.$mediaBehavior.'" aria-label="Media embed, click to play" tabindex="0"' : '' !!}{!! !empty($embed_height) ? ' style="height: ' . $embed_height . '"' : '' !!}{!! isset($media['restrict']) && $media['restrict'] ? ' data-restrict="true"' : '' !!}>
        @if ($type == 'image')
            @if ($showUrlFullscreen)
                <a href="{!! $item['urlTitle'] !!}">
            @endif
            @component('components.atoms._img')
                @slot('image', $media)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($showUrlFullscreen)
                </a>
            @endif
        @elseif ($type == 'embed' and !$poster and !$fullscreen)
            {!! $media['embed'] ?? '' !!}
        @elseif ($type == 'embed' and $poster and !$fullscreen)
            {!! $media['embed'] ?? '' !!}
            @component('components.atoms._img')
                @slot('image', $poster)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @elseif ($type == 'embed' and $poster and $fullscreen)
            @component('components.atoms._img')
                @slot('image', $poster)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @elseif ($type == 'module3d' and $poster)
            @component('components.atoms._img')
                @slot('image', $poster)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            @if ($size === 'hero')
                @component('components.atoms._img')
                    @slot('image', $media['fallbackImage'])
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
            @component('components.atoms._video')
                @slot('video', $media)
                @if ($size === 'hero')
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @else
                    @slot('controls', true)
                @endif
                @slot('title', $media['fallbackImage']['alt'] ?? null)
            @endcomponent
            @component('components.atoms._media-play-pause-video')
            @endcomponent
        @endif
        @if (isset($item['downloadable']) and $item['downloadable'])
            @component('components.atoms._btn')
                @slot('variation', 'btn--septenary btn--icon btn--icon-circle-48 m-media__btn-download')
                @slot('font', '')
                @slot('icon', 'icon--download--24')
                @slot('tag', 'a')
                @slot('href', $media['downloadUrl'])
                @slot('download', true)
                @slot('ariaLabel','Download image')
            @endcomponent
        @endif
        @if ($type !== 'embed' and $type !== 'module3d' and $fullscreen)
            @component('components.atoms._btn')
                @slot('variation', 'm-media__btn-fullscreen btn--septenary btn--icon btn--icon-circle-48')
                @slot('font', '')
                @slot('icon', 'icon--zoom--24')
                @slot('ariaLabel', 'Open image full screen')
            @endcomponent
        @endif
        @if ($type == 'module3d' and $fullscreen)
            @component('components.atoms._btn')
                @slot('variation', 'm-media__btn-module3d btn--septenary btn--icon btn--icon-sq')
                @slot('font', '')
                @slot('icon', 'icon--tour3d')
                @slot('ariaLabel', 'Open the 3D module')
            @endcomponent
        @endif

        @if ($type == 'embed' and $poster)
            <svg class="icon--play-multi">
                <use xlink:href="#icon--play--48" />
                <use xlink:href="#icon--play--64" />
                <use xlink:href="#icon--play--96" />
            </svg>
        @endif

        @if ($fullscreen and $type == 'embed')
            <textarea style="display: none;">{!! is_array($media['embed']) ? Arr::first($media['embed']) : $media['embed'] !!}</textarea>
        @endif

        @if ($fullscreen and $type == 'module3d')
            <textarea style="display: none;">@component('components.molecules._m-viewer-3d')
                @slot('type', 'full-width')
                @slot('uid', $media['model_id'])
                @slot('annotations', $media['annotation_list'])
                @slot('artwork', $media['artwork'])
                @slot('guided', $media['guided'])
            @endcomponent</textarea>
        @endif

    </span>
    @if ((!isset($item['hideCaption']) or (isset($item['hideCaption']) and !$item['hideCaption'])) and (isset($item['caption']) or isset($item['captionTitle'])))
    <figcaption>
        @if ($size == 'gallery')
            @if (isset($item['captionTitle']))
                @if(isset($item['urlTitle']) && $item['urlTitle'])
                    <strong class="f-caption"><a href="{!! $item['urlTitle'] !!}">{!! $item['captionTitle'] !!}</a></strong> <br>
                @else
                    <strong class="f-caption">{!! $item['captionTitle'] !!}</strong> <br>
                @endif
            @endif
            @if (isset($item['caption']))<span class="f-caption">{!! $item['caption'] !!}</span>@endif
        @else
            @if (isset($item['captionTitle']))
                @if(isset($item['urlTitle']) && $item['urlTitle'])
                    <strong class="f-caption-title"><a href="{!! $item['urlTitle'] !!}">{!! $item['captionTitle'] !!}</a></strong> <br>
                @else
                    <strong class="f-caption-title">{!! $item['captionTitle'] !!}</strong> <br>
                @endif
            @endif
            @if (isset($item['caption']))
                <span class="f-caption">{!! $item['caption'] !!}</span>
                @if (!isset($item['hideShare']))
                    @component('components.atoms._btn')
                        @slot('variation', 'btn--quinary btn--icon m-media__share')
                        @slot('font', '')
                        @slot('icon', 'icon--share--24')
                        @slot('behavior','sharePage')
                        @slot('ariaLabel','Share page')
                    @endcomponent
                @endif
            @endif
        @endif
    </figcaption>
    @endif
</{{ $tag ?? 'figure' }}>
