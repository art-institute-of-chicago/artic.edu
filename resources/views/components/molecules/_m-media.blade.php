@php

    $type = isset($item['type']) ? $item['type'] : 'video';
    $size = isset($item['size']) ? $item['size'] : 's';
    $useContain = $item['useContain'] ?? false;
    $disablePlaceholder = $item['disablePlaceholder'] ?? false;
    $useAltBackground = $item['useAltBackground'] ?? false;
    $hasRestriction = isset($item['restricted']) ? $item['restricted'] : false;
    $media = $item['media'];
    $fullscreen = (isset($item['fullscreen']) && $item['fullscreen']) && (!isset($media['restrict']) || !$media['restrict']);
    $poster = isset($item['poster']) ? $item['poster'] : false;
    $manifest = isset($item['manifest']) ? $item['manifest'] : false;
    $default_view = isset($item['default_view']) ? $item['default_view'] : 'single';

    $fitCaptionTitle = $type === 'artist';
    $type = $type === 'artist' ? 'image' : $type;

    $loop = isset($item['loop']) && $item['loop'];
    $loop_or_once = isset($item['loop_or_once']) ? $item['loop_or_once'] : 'loop';

    // WEB-912: For Gallery Items; image module is an array, but gallery item is object?
    if (isset($item['videoUrl']) || (!is_array($item) && !empty($item->present()->input('videoUrl'))))
    {
        $type = 'embed';
        $poster = $media;
        $media['embed'] = \App\Facades\EmbedConverterFacade::convertUrl($item['videoUrl'] ?? $item->present()->input('videoUrl'));
    }

    if ($type === 'embed' and strrpos($media['embed'],'api.soundcloud.com')) {
        $size = 's';
    }

    $defaultSrcset = array(300,600,800,1200,1600,2000,3000,4500);

    if ($item['isArtwork'] ?? $item['useArtworkSrcset'] ?? false) {
        $defaultSrcset = ImageHelpers::aic_getSrcsetForImage($media, $item['isPublicDomain'] ?? false);
    }

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

    if ($type == 'embed') {
        if (!$poster) {
            $fullscreen = false;
        }

        $imageSettings['ratio'] = '16:9';

        // Allow soundcloud embed to expand in height
        // @see _m-media.scss
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
    if ($type == 'module360') {
      $mediaBehavior = 'triggerMediaModal';
    }
    if ($type == 'moduleMirador') {
      $mediaBehavior = 'triggerMediaModal';
    }
    if ($fullscreen and $type == 'embed') {
      $mediaBehavior = 'triggerMediaModal';
    }
    if (!$fullscreen and $type == 'embed') {
      $mediaBehavior = 'triggerMediaInline';
    }
    if (!$fullscreen and $type == 'virtualtour') {
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

    global $_allowAdvancedModalFeatures;
@endphp

<{{ $tag ?? 'figure' }} data-type="{{ $type }}" data-title="{{ $item['captionTitle'] ?? $item['caption'] ?? $media['caption'] ?? (isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '') }}"{!! $hasRestriction ? ' data-restricted="true"' : '' !!} class="m-media m-media--{{ $size }}{{ $useContain ? ' m-media--contain' : '' }}{{ (isset($item['variation'])) ? ' '.$item['variation'] : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}>
    <div class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : (($type === 'virtualtour') ? ' m-media__img--virtualtour' : '' )}}{{ $useAltBackground ? ' m-media__img--alt-background' : '' }}{{ $disablePlaceholder ? ' m-media__img--disable-placeholder' : '' }}" data-behavior="fitText {!! ($mediaBehavior) ? $mediaBehavior  : '' !!}" data-platform="{!! isset($item['platform']) ? $item['platform'] : '' !!}" {!! ($mediaBehavior) ? ' aria-label="Media embed, click to play" tabindex="0"' : '' !!}{!! !empty($embed_height) ? ' style="height: ' . $embed_height . '"' : '' !!}{!! ($_allowAdvancedModalFeatures ?? false) ? ' data-modal-advanced="true"' : '' !!}{!! isset($media['restrict']) && $media['restrict'] ? ' data-restrict="true"' : '' !!}{!! isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '' !!}{!! !empty($item['credit']) ? ' data-credit="' . $item['credit'] . '"' : '' !!}>
        @if ($useContain && ($size === 'm' || $size === 'l'))
            <div class="m-media__contain--spacer" style="padding-bottom: {{ min(62.5, intval($item['media']['height'] ?? 10) / intval($item['media']['width'] ?? 16) * 100) }}%"></div>
        @endif
        @if ($type == 'image')
            @if ($showUrlFullscreen)
                <a href="{!! $item['urlTitle'] !!}"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}>
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
        @elseif ($type == 'module360' and $poster)
            @component('components.atoms._img')
                @slot('image', $poster)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @elseif ($type == 'moduleMirador' and $poster)
            @component('components.atoms._img')
                @slot('image', $poster)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @elseif ($type == 'virtualtour')
            @component('components.molecules._m-viewer-virtualtour')
                @slot('vtourxml', $media['vtourxml'])
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
                    @slot('controls', !$loop)
                    @slot('autoplay', $loop)
                    @slot('loop', $loop && $loop_or_once == 'loop')
                    @slot('muted', $loop)
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
        @if ($type == 'module360')
            @component('components.atoms._btn')
                @slot('variation', 'm-media__btn-module360 btn--septenary btn--icon btn--icon-sq')
                @slot('font', '')
                @slot('icon', 'icon--view360')
                @slot('ariaLabel', 'Open 360 Viewer')
            @endcomponent
        @endif
        @if ($type == 'moduleMirador')
            @component('components.atoms._btn')
                @slot('variation', 'm-media__btn-moduleMirador btn--septenary btn--icon btn--icon-sq')
                @slot('font', '')
                @slot('icon', 'icon--view-mirador')
                @slot('ariaLabel', 'Open Mirador Viewer')
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
                @slot('type', 'modal')
                @slot('uid', $media['model_id'])
                @slot('cc', $media['cc'])
                @slot('annotations', $media['annotation_list'])
                @slot('artwork', $media['artwork'])
                @slot('guided', $media['guided'])
                @slot('title', $media['title'] ? $media['title'].' - Modal 3D' : 'Modal 3D')
            @endcomponent</textarea>
        @endif

        @if ($type == 'module360')
        <textarea style="display: none;">@component('components.molecules._m-viewer-360')
            @slot('type', 'modal')
            @slot('title', $media['title'] ? $media['title'].' - Modal 360' : 'Modal 360')
          @endcomponent</textarea>
        @endif

        @if ($type == 'moduleMirador')
        <textarea style="display: none;">@component('components.molecules._m-viewer-mirador')
            @slot('type', 'modal')
            @slot('title', $media['title'] ? $media['title'].' - Modal Mirador' : 'Modal Mirador')
            @slot('manifest', $manifest)
            @slot('defaultView', $default_view)
          @endcomponent</textarea>
        @endif

    </div>
    @if ((!isset($item['hideCaption']) or (isset($item['hideCaption']) and !$item['hideCaption'])) and (isset($item['caption']) or isset($item['captionTitle'])))
    <figcaption>
        @if (isset($item['captionTitle']))
            <div class="{{ $size !== 'gallery' || isset($item['caption']) ? 'f-caption-title' : 'f-caption' }}"><div>
                @if(isset($item['urlTitle']) && $item['urlTitle'])
                    <a href="{!! $item['urlTitle'] !!}">{!! $item['captionTitle'] !!}</a>
                @else
                    {!! $item['captionTitle'] !!}
                @endif
            </div></div> <br>
        @endif
        @if (isset($item['caption']))
            <div class="{{ $fitCaptionTitle ? 'f-fit-text' : '' }} f-caption">{!! $item['caption'] !!}</div>
        @endif
    </figcaption>
    @endif
</{{ $tag ?? 'figure' }}>
