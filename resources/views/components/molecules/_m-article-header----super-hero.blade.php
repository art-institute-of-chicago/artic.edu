<{{ $tag or 'header' }} class="m-article-header m-article-header--super-hero{{ (isset($variation)) ? ' '.$variation : '' }}">
  <div class="m-article-header__img">
      @if ($img)
        @component('components.atoms._img')
            @slot('image', $img)
            @slot('settings', array(
                'srcset' => array(300,600,1000,1500,3000),
                'sizes' => '100vw',
            ))
        @endcomponent
      @endif
  </div>
  <div class="m-article-header__text">
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-display-2')
            {{ $title }}
        @endcomponent
      @endif
      @if ($dateStart and $dateEnd)
        @component('components.atoms._date')
            {{ $dateStart->format('M j, Y') }} &ndash; {{ $dateEnd->format('M j, Y') }}
        @endcomponent
      @elseif (isset($date))
        @component('components.atoms._date')
            @slot('tag','p')
            {{ $date->format('F j, Y') }}
        @endcomponent
      @endif
      @if (isset($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
      @endif
      @if (isset($intro))
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font','f-deck')
            @slot('variation', 'm-article-header__intro')
            {{ $intro }}
        @endcomponent
      @endif
      @if (isset($img) and isset($img['credit']))
        @if ($img['creditUrl'])
            <a href="{{ $img['creditUrl'] }}" class="m-article-header__info-trigger">
                <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </a>
        @else
            <button class="m-article-header__info-trigger" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
              <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </button>
            <div class="m-article-header__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
              <p class="f-caption">{{ $img['credit'] }}</p>
            </div>
        @endif
      @endif
  </div>
</{{ $tag or 'header' }}>
