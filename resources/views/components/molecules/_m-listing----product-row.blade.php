<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $product->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--square">
      @component('components.atoms._img')
          @slot('src', $product->image['src'])
      @endcomponent
    </span>
    <span class="m-listing__meta">
      @component('components.atoms._title')
          {{ $product->title }}
      @endcomponent
      <br>
      @component('components.atoms._short-description')
          {{ $product->shortDesc }}
      @endcomponent
      <br>
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
  </a>
</{{ $tag or 'li' }}>
