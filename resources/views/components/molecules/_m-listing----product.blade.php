<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
<a href="{{ $item->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--square">
        @if ($item->image)
            @component('components.atoms._img')
                @slot('src', $item->image['src'])
                @slot('srcset', $item->image['srcset'])
                @slot('width', $item->image['width'])
                @slot('height', $item->image['height'])
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @if (!isset($simple) or !$simple)
            @component('components.atoms._type')
                {{ $item->type }}
            @endcomponent
            <br>
        @endif
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
