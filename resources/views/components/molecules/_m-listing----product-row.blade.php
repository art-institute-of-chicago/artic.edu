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
     @elseif ($item->imageFront('hero'))
         @component('components.atoms._img')
             @slot('image', $item->imageFront('hero'))
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
          {{ $item->description }}
      @endcomponent
      <br>
      @if ($item->sale_price)
          @component('components.atoms._price')
              @slot('salePrice')
                  {{ $item->currency }}{{ $item->price }}
              @endslot
              {{ $item->currency }}{{ $item->sale_price }}
          @endcomponent
      @else
          @component('components.atoms._price')
              {{ $item->currency }}{{ $item->price }}
          @endcomponent
      @endif
    </span>
  </a>
</{{ $tag or 'li' }}>
