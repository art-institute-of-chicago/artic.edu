@php
    $fullscreen = ($item->embed and isset($fullscreen) and $fullscreen) ? true : false;
@endphp
<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>

    @if ($fullscreen)
        <a href="{{ route('videos.show', $item) }}" class="m-listing__link" data-behavior="triggerMediaModal">
    @else
        <a href="{{ route('videos.show', $item) }}" class="m-listing__link">
    @endif
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
            <svg class="icon--play--48"><use xlink:href="#icon--play--48"></use></svg>
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
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
