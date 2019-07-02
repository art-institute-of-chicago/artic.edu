<{{ $tag ?? 'li' }} class="m-listing m-listing--label m-listing--interactive m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->getUrl() ?? route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!} data-no-ajax>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
            @if ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            @else
                <span class="default-img"></span>
            @endif
            @if ($item->isVideo)
                <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
            @endif

            <span class="m-listing__img__overlay">
                <svg class="icon--closer-look"><use xlink:href="#icon--closer-look"></use></svg>
            </span>
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">Interactive Feature</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{!! $item->title_display ?? $item->title !!}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">
                    @if ($item->last_updated)
                        @component('components.atoms._date')
                            {{ date('F j, Y', strtotime($item->last_updated)) }}
                        @endcomponent
                    @endif
                </span>
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
