<!-- @if (!empty($item->title))
    <div>
        <h2 style="margin-top:40px;font-size:20px;text-transform:uppercase;">{!! $item->title !!}</h2>
    </div>
@endif -->

@php

    $type = isset($item['type']) ? $item['type'] : 'video';
    $size = isset($item['size']) ? $item['size'] : 's';

    $disablePlaceholder = $item['disablePlaceholder'] ?? false;
    $hasRestriction = isset($item['restricted']) ? $item['restricted'] : false;
    $media = $item['media'];
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

    global $_allowAdvancedModalFeatures;
@endphp

<{{ $tag ?? 'figure' }} data-type="{{ $type }}" data-title="{{ $item['captionTitle'] ?? $item['caption'] ?? $media['caption'] ?? (isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '') }}"{!! $hasRestriction ? ' data-restricted="true"' : '' !!} class="m-media m-media--{{ $size }}{{ (isset($item['variation'])) ? ' '.$item['variation'] : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}>
    <div class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : (($type === 'virtualtour') ? ' m-media__img--virtualtour' : '' )}}{{ $disablePlaceholder ? ' m-media__img--disable-placeholder' : '' }}" data-behavior="fitText" data-platform="{!! isset($item['platform']) ? $item['platform'] : '' !!}" {!! !empty($embed_height) ? ' style="height: ' . $embed_height . '"' : '' !!}{!! ($_allowAdvancedModalFeatures ?? false) ? ' data-modal-advanced="true"' : '' !!}{!! isset($media['restrict']) && $media['restrict'] ? ' data-restrict="true"' : '' !!}{!! isset($media['title']) && $media['title'] ? ' data-title="'.$media['title'].'"' : '' !!}{!! !empty($item['credit']) ? ' data-credit="' . $item['credit'] . '"' : '' !!}>
        @if ($type == 'image')
            @component('components.atoms._img')
                @slot('image', $media)
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
                    @slot('controls', !$loop)
                    @slot('autoplay', $loop)
                    @slot('loop', $loop && $loop_or_once == 'loop')
                    @slot('muted', $loop)
                    @slot('playsinline', $loop)
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

    </div>
</{{ $tag ?? 'figure' }}>
