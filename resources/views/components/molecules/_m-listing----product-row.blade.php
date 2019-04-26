<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{!! $item->web_url !!}" class="m-listing__link" target="_blank"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
     @if ($item->imageFront('hero'))
         @component('components.atoms._img')
             @slot('image', $item->imageFront('hero'))
             @slot('settings', $imageSettings ?? '')
         @endcomponent
         @if ($item->videoFront)
             @component('components.atoms._video')
                 @slot('video', $item->videoFront)
                 @slot('autoplay', true)
                 @slot('loop', true)
                 @slot('muted', true)
                 @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? null)
             @endcomponent
             @component('components.atoms._media-play-pause-video')
             @endcomponent
         @endif
     @else
         <span class="default-img"></span>
     @endif
    </span>
    <span class="m-listing__meta">
      @component('components.atoms._title')
          {!! $item->present()->title !!}
      @endcomponent
      <br>
      @component('components.atoms._short-description')
          {!! $item->present()->description !!}
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
</{{ $tag ?? 'li' }}>
