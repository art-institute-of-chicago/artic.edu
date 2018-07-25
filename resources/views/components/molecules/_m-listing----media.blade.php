@php
    $fullscreen = ($item->embed and isset($fullscreen) and $fullscreen) ? true : false;
@endphp
<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>

    {{-- TODO: Audio should not be using the video route --}}
    @if ($fullscreen)
        <a href="{{ route('videos.show', $item) }}" class="m-listing__link" data-behavior="triggerMediaModal"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    @else
        <a href="{{ route('videos.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    @endif
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
            @if (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            @else
                <span class="default-img"></span>
            @endif
            <svg class="icon--play--48"><use xlink:href="#icon--play--48"></use></svg>
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @if ($item->embed)
                <em class="type f-tag">{{ (strrpos((is_array($item->embed) ? array_first($item->embed) : $item->embed), "api.soundcloud.com") > 0) ? 'Audio' : 'Video' }}</em>
                <br>
            @endif
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{!! $item->title_display ?? $item->title !!}</strong>
            @if ($item->timeStamp)
                <br>
                <span class="subtitle f-secondary">{{ $item->timeStamp }}</span>
            @endif
        </span>
        @if ($fullscreen)
        <textarea style="display: none;">{!! is_array($item->embed) ? array_first($item->embed) : $item->embed !!}</textarea>
        @endif
    </a>
</{{ $tag or 'li' }}>
