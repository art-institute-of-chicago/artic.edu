<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! route('artworks.show', ['id' => $item->id, 'slug' => $item->titleSlug ] + request()->input()) !!}" class="m-listing__link" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
            @if (isset($image) || $item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront()['alt'] ?? $image['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            @else
                <span class="default-img"></span>
            @endif
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @if ( !empty( $item->subtype ) )
                <em class="type f-tag">{{ $item->subtype }}</em>
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-1')
                {{ $item->listingTitle }}
            @endcomponent
            <br>
            <span class="subtitle {{ $subtitleFont ?? 'f-secondary'}}">{{ $item->listingSubtitle }}</span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
