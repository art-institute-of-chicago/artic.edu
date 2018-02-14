<{{ $tag or 'li' }} class="m-listing{{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('src', $item->image['src'])
                    @slot('srcset', $item->image['srcset'])
                    @slot('width', $item->image['width'])
                    @slot('height', $item->image['height'])
                @endcomponent
            @endif
        </span>
        <span class="m-listing__meta">
            @if ( !empty( $item->sku ) )
                <em class="type f-tag">{{ $item->sku }}</em>
                <br>
            @endif

            <strong class="title f-list-2">{{ $item->title }}</strong>
            <br>
            <span class="subtitle f-body">{{ $item->artist_display }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
