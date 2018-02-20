<{{ $tag or 'li' }} class="m-listing{{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @if (isset($item->image['image_id']))
                        @slot('image_id', $item->image['image_id'])
                    @endif
                    @if (isset($item->image['src']))
                        @slot('src', $item->image['src'])
                    @endif
                    @if (isset($item->image['srcset']))
                        @slot('srcset', $item->image['srcset'])
                    @endif
                    @if (isset($item->image['width']))
                        @slot('width', $item->image['width'])
                    @endif
                    @if (isset($item->image['height']))
                        @slot('height', $item->image['height'])
                    @endif
                    @if (isset($item->image['sizes']))
                        @slot('height', $item->image['sizes'])
                    @endif
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
