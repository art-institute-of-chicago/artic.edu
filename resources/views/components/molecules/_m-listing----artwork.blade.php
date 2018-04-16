<{{ $tag or 'li' }} class="m-listing{{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{{ route('artworks.show', $item) }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif (isset($image) || $item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @if ( !empty( $item->sku ) )
                <em class="type f-tag">{{ $item->sku }}</em>
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-1')
                {{ $item->title }}
            @endcomponent
            <br>
            <span class="subtitle {{ $subtitleFont ?? 'f-secondary'}}">{{ $item->artist_display }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
