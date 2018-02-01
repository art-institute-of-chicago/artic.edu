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
