<{{ $tag ?? 'li' }} class="m-listing m-listing--row m-listing--interactive m-listing--label {{ (isset($variation) and $variation === 'o-pinboard__item') ? ' m-listing--variable-height' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! $item->getUrl() ?? route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!} data-no-ajax>
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>

            @if (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif

            <span class="m-listing__img__overlay">
                <svg class="icon--closer-look"><use xlink:href="#icon--closer-look"></use></svg>
            </span>
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-4')
                {{ $item->title }}
            @endcomponent
            @if ($item->description)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->description }}</span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
