<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
<a href="{!! $item->web_url !!}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
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
</{{ $tag or 'li' }}>
