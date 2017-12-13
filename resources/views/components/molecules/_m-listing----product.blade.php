<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
<a href="{{ $product->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--square">
        @component('components.atoms._img')
            @slot('src', $product->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
        @if (!isset($simple) or !$simple)
            @component('components.atoms._type')
                {{ $product->type }}
            @endcomponent
            <br>
        @endif
        @component('components.atoms._title')
            {{ $product->title }}
        @endcomponent
        @if (!isset($simple) or !$simple)
            <br>
            <span class="m-listing__meta-bottom">
                @if ($product->priceSale)
                    @component('components.atoms._price')
                        @slot('salePrice')
                            {{ $product->currency }}{{ $product->price }}
                        @endslot
                        {{ $product->currency }}{{ $product->priceSale }}
                    @endcomponent
                @else
                    @component('components.atoms._price')
                        {{ $product->currency }}{{ $product->price }}
                    @endcomponent
                @endif
            </span>
        @endif
    </span>
</a>
</{{ $tag or 'li' }}>
