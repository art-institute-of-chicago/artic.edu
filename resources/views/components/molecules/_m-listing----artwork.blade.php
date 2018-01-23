<{{ $tag or 'li' }} class="m-listing{{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $artwork->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--tall">
            @component('components.atoms._img')
                @slot('src', $artwork->image['src'])
                @slot('srcset', $artwork->image['srcset'])
                @slot('width', $artwork->image['width'])
                @slot('height', $artwork->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
            @if ( !empty( $artwork->sku ) )
                <em class="type f-tag">{{ $artwork->sku }}</em>
                <br>
            @endif

            <strong class="title f-list-2">{{ $artwork->title }}</strong>
            <br>
            <span class="subtitle f-body">{{ $artwork->artist }}, {{ $artwork->date }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
