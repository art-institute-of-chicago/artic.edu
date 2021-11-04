<{{ $tag ?? 'li' }} class="m-listing m-listing--label m-listing--interactive {{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! $item->getUrl() ?? route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!} data-no-ajax>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('hero'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                @else
                    <span class="default-img"></span>
                @endif
                <span class="m-listing__img__overlay">
                    <svg class="icon--closer-look"><use xlink:href="#icon--closer-look"></use></svg>
                </span>
            </span>
        @endif
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <em class="type f-tag">Interactive Feature</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-1')
                {{ $item->title }}
            @endcomponent
            <br>
            @if (isset($showDescription) && $item->listing_description)
                @component('components.atoms._short-description')
                    {!! StringHelpers::truncateStr($item->present()->listing_description) !!}
                @endcomponent
                <br>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
