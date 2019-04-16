<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
<a href="{!! $item->web_url !!}" class="m-listing__link" target="_blank"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
        @if ($item->imageFront())
            @component('components.atoms._img')
                @slot('image', $item->imageFront())
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($item->videoFront)
            @component('components.atoms._video')
                @slot('video', $item->videoFront)
                @slot('autoplay', true)
                @slot('loop', true)
                @slot('muted', true)
                @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront()['alt'] ?? null)
            @endcomponent
            @component('components.atoms._media-play-pause-video')
            @endcomponent
        @endif
        @else
            <span class="default-img"></span>
        @endif
    </span>
    <span class="m-listing__meta">
{{--         @if (!isset($simple) or !$simple)
            @component('components.atoms._type')
                {{ $item->type }}
            @endcomponent
            <br>
        @endif --}}
        @component('components.atoms._title')
            {{ $item->title }}
        @endcomponent
        @if (!isset($simple) or !$simple)
            <br>
            <span class="m-listing__meta-bottom">
                @if ($item->priceSale)
                    @component('components.atoms._price')
                        @slot('salePrice')
                            {{ $item->currency }}{{ $item->price }}
                        @endslot
                        {{ $item->currency }}{{ $item->priceSale }}
                    @endcomponent
                @else
                    @component('components.atoms._price')
                        {{ $item->currency }}{{ $item->price }}
                    @endcomponent
                @endif
            </span>
        @endif
    </span>
</a>
</{{ $tag ?? 'li' }}>
