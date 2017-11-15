<{{ $tag or 'li' }} class="m-listing">
  <a href="{{ $product->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--square">
      <img src="{{ $product->image['src'] }}">
    </span>
    <span class="m-listing__meta">
      <strong class="m-listing__title f-list-2">{{ $product->title }}</strong> <br>
      <span class="m-listing__meta-bottom">
        @if ($product->priceSale)
        <span class="m-listing__price f-secondary"><strike>{{ $product->currency }}{{ $product->price }}</strike> <span class="m-listing__sale-price">{{ $product->currency }}{{ $product->priceSale }}</span></span>
        @else
        <span class="m-listing__price f-secondary">{{ $product->currency }}{{ $product->price }}</span>
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
