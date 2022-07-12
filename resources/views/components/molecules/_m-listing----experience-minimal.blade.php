<{{ $tag ?? 'li' }} class="m-listing m-listing--label m-listing--interactive m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->getUrl() ?? route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!} data-no-ajax>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
            @if ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                @endcomponent
            @else
                <span class="default-img"></span>
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
                    @if ($item->updated_at)
                        @component('components.atoms._date')
                            {{ date('F j, Y', strtotime($item->updated_at)) }}
                        @endcomponent
                    @endif
                </span>
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
