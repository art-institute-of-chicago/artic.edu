<{{ $tag or 'li' }} class="m-listing">
  <a href="{{ $product->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--square">
      <img src="{{ $product->image['src'] }}">
    </span>
    <span class="m-listing__meta">
      <strong class="title f-list-2">{{ $product->title }}</strong> <br>
      <span class="m-listing__meta-bottom">
        @if ($product->priceSale)
        <span class="price price--sale f-secondary"><strike>{{ $product->currency }}{{ $product->price }}</strike> <em>{{ $product->currency }}{{ $product->priceSale }}</em></span>
        @else
        <span class="price f-secondary">{{ $product->currency }}{{ $product->price }}</span>
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
