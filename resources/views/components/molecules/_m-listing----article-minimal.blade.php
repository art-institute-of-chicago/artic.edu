<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $href ?? route('articles.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
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
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{!! $item->present()->subtype !!}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{!! $item->present()->title_display ?? $item->present()->title !!}</strong>
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
</{{ $tag ?? 'li' }}>
