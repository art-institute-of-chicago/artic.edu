@php
    $type = isset($type) ? $type : 'video';
@endphp
<figure class="m-media m-media--{{ (isset($variation)) ? $variation : 's' }}">
    <span class="m-media__img{{ ($type === 'embed' || $type === 'video') ? ' m-media__img--video' : '' }}">
        @if ($type == 'image')
            @component('components.atoms._img')
                @slot('src', $media['src'] ?? '')
                @slot('srcset', $media['srcset'] ?? '')
                @slot('sizes', $media['sizes'] ?? '')
                @slot('width', $media['width'] ?? '')
                @slot('height', $media['height'] ?? '')
            @endcomponent
        @elseif ($type == 'embed')
            {{ $media['$embed'] ?? '' }}
        @else
            @component('components.atoms._video')
                @slot('src', $media['src'] ?? '')
                @slot('poster', $media['poster'] ?? '')
            @endcomponent
        @endif
    </span>
    <figcaption>
        @if (isset($variation) && $variation == 'gallery')
            @if (isset($captionTitle))<strong class="f-caption">{{ $captionTitle }}</strong> <br>@endif
            @if (isset($caption))<span class="f-caption">{{ $caption }}</span>@endif
        @else
            @if (isset($captionTitle))<strong class="f-caption-title">{{ $captionTitle }}</strong> <br>@endif
            @if (isset($caption))<span class="f-caption">{{ $caption }}</span>@endif
            @component('components.atoms._btn')
                @slot('variation', 'btn--quintinary btn--icon m-media__share')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
            @endcomponent
        @endif
    </figcaption>
</figure>
