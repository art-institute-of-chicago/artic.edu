@php
    $type = isset($item['type']) ? $item['type'] : 'video';
    $size = isset($item['size']) ? $item['size'] : 's';
    $media = $item['media'];
    $tag = (isset($item['url']) && $item['url'] && $type !== 'embed' && $type !== 'video') ? 'a' : 'span';
@endphp
<figure data-type="{{ $type }}" class="m-media m-media--{{ $size }}{{ (isset($item['variation'])) ? ' '.$item['variation'] : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <{{ $tag }}{{ ($tag === 'a') ? ' href="'.$item['url'].'"' : '' }} class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : '' }}">
        @if ($type == 'image')
            @component('components.atoms._img')
                @slot('src', $media['src'] ?? '')
                @slot('srcset', $media['srcset'] ?? '')
                @slot('sizes', $media['sizes'] ?? '')
                @slot('width', $media['width'] ?? '')
                @slot('height', $media['height'] ?? '')
            @endcomponent
        @elseif ($type == 'embed')
            {!! $media['embed'] ?? '' !!}
        @else
            @component('components.atoms._video')
                @slot('src', $media['src'] ?? '')
                @slot('poster', $media['poster'] ?? '')
                @slot('controls', true)
            @endcomponent
        @endif
        @if (isset($item['downloadable']) and $item['downloadable'] && $tag !== 'a')
            @component('components.atoms._btn')
                @slot('variation', 'btn--septenary btn--icon btn--icon-circle-48 m-media__download-btn')
                @slot('font', '')
                @slot('icon', 'icon--download--24')
                @slot('tag', 'a')
                @slot('href', $media['downloadUrl'])
                @slot('download', true)
            @endcomponent
        @endif
    </{{ $tag }}>
    @if (!isset($item['hideCaption']) or (isset($item['hideCaption']) and !$item['hideCaption']))
    <figcaption>
        @if ($size == 'gallery')
            @if (isset($item['captionTitle']))<strong class="f-caption">{{ $item['captionTitle'] }}</strong> <br>@endif
            @if (isset($item['caption']))<span class="f-caption">{{ $item['caption'] }}</span>@endif
        @else
            @if (isset($item['captionTitle']))<strong class="f-caption-title">{{ $item['captionTitle'] }}</strong> <br>@endif
            @if (isset($item['caption']))<span class="f-caption">{{ $item['caption'] }}</span>@endif
            @component('components.atoms._btn')
                @slot('variation', 'btn--quinary btn--icon m-media__share')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
                @slot('behavior','sharePage')
            @endcomponent
        @endif
    </figcaption>
    @endif
</figure>
