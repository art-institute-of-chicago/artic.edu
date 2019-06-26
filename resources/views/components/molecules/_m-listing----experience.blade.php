<{{ $tag ?? 'li' }} class="m-listing m-listing--label {{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! $item->getUrl() ?? route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>

            @if (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            @else
                <span class="default-img"></span>
            @endif

            <span class="m-listing__img__overlay">
                <svg class="icon--closer-look"><use xlink:href="#icon--closer-look"></use></svg>
            </span>
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <em class="type f-tag">Interactive Feature</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-1')
                {{ $item->title }}
            @endcomponent
            <br>
            <span class="subtitle {{ $subtitleFont ?? 'f-secondary'}}">{{ $item->subtitle }}</span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
