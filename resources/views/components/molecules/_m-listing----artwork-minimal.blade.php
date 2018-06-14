<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}" itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! route('artworks.show', $item) !!}" class="m-listing__link" itemprop="url">
        <span class="m-listing__img m-listing__img--contain m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
