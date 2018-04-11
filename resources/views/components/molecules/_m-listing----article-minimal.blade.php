<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $href ?? route('articles.show', $item) !!}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
            @if ($item->isVideo)
                <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
            @endif
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">
                    @if ($item->date)
                        @component('components.atoms._date')
                            {{ $item->date->format('F j, Y') }}
                        @endcomponent
                    @endif
                </span>
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
