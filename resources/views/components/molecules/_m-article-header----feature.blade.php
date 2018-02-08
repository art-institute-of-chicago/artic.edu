<{{ $tag or 'header' }} class="m-article-header m-article-header--feature{{ (isset($variation)) ? ' '.$variation : '' }}">
  <div class="m-article-header__img">
      @if (isset($img))
        @component('components.atoms._img')
            @slot('src', $img['src'])
            @slot('width', $img['width'])
            @slot('height', $img['height'])
        @endcomponent
      @endif
  </div>
  @if (isset($img))
  <div class="m-article-header__text" style="background-image: url({{ $img['src'] }});">
  @else
  <div class="m-article-header__text">
  @endif
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            {{ $title }}
        @endcomponent
      @endif
      @if (isset($dateStart) and isset($dateEnd))
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

      @if ($img['creditUrl'])
          <a href="{{ $img['creditUrl'] }}" class="m-article-header__img-credit f-secondary" data-gallery-credit>
              {{ $img['credit'] }}
          </a>
      @else
          <span class="m-article-header__img-credit f-secondary" data-gallery-credit>
              {{ $img['credit'] }}
          </span>
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
