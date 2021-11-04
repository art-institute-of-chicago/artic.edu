@php
    $fullscreen = ($item->embed and isset($fullscreen) and $fullscreen) ? true : false;
@endphp
<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    {{-- WEB-2240: Audio should not be using the video route --}}
    <a href="{{ route('videos.show', $item) }}" class="m-listing__link" {!! $fullscreen ? 'data-behavior="triggerMediaModal"' : '' !!} {!! $gtmAttributes ?? '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('hero'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                @else
                    <span class="default-img"></span>
                @endif
                <svg class="icon--play--48"><use xlink:href="#icon--play--48"></use></svg>
            </span>
        @endif
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @if ($item->embed)
                <em class="type f-tag">{{ (strrpos((is_array($item->embed) ? Arr::first($item->embed) : $item->embed), "api.soundcloud.com") > 0) ? 'Audio' : 'Video' }}</em>
                <br>
            @endif
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{!! $item->present()->title_display ?? $item->present()->title !!}</strong>
            @if (!isset($hideDescription) || (isset($hideDescription) && !($hideDescription)))
                @if ($item->timeStamp)
                    <br>
                    <span class="subtitle f-secondary">{{ $item->timeStamp }}</span>
                @endif
            @endif
        </span>
        @if ($fullscreen)
            <textarea style="display: none;">{!! is_array($item->embed) ? Arr::first($item->embed) : $item->embed !!}</textarea>
        @endif
    </a>
</{{ $tag ?? 'li' }}>
