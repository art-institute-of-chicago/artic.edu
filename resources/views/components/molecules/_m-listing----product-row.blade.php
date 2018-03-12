<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $item->slug }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--square' }}">
     @if ($item->imageFront())
         @component('components.atoms._img')
             @slot('image', $item->imageFront())
             @slot('settings', $imageSettings ?? '')
         @endcomponent
     @endif
    </span>
    <span class="m-listing__meta">
      @component('components.atoms._title')
          {{ $item->title }}
      @endcomponent
      <br>
      @component('components.atoms._short-description')
          {{ $item->shortDesc }}
      @endcomponent
      <br>
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
  </a>
</{{ $tag or 'li' }}>
