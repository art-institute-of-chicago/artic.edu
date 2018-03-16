<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if ($item->embed)
        <a href="{{ $item->url }}" class="m-listing__link" data-behavior="triggerMediaModal">
    @else
        <a href="{{ $item->url }}" class="m-listing__link">
    @endif
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
            <svg class="icon--play--48"><use xlink:href="#icon--play--48"></use></svg>
        </span>
        <span class="m-listing__meta">
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            @if ($item->timeStamp)
                <br>
                <span class="subtitle f-secondary">{{ $item->timeStamp }}</span>
            @endif
        </span>
        @if ($item->embed)
        <textarea style="display: none;">{!! array_first($item->embed) !!}</textarea>
        @endif
    </a>
</{{ $tag or 'li' }}>
