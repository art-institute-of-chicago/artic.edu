<{{ $tag or 'header' }} class="m-article-header m-article-header--hero{{ (isset($variation)) ? ' '.$variation : '' }}">
  <div class="m-article-header__img">
      @if (isset($img))
        @component('components.atoms._img')
            @slot('src', $img['src'])
            @slot('width', $img['width'])
            @slot('height', $img['height'])
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
      @if (isset($date))
        @component('components.atoms._date')
            @slot('tag','p')
            {{ $date }}
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
      @if (isset($img) and isset($img['info']))
      <button class="m-article-header__info-trigger" id="image-info-trigger" aria-selected="false" aria-controls="image-info" aria-expanded="false" data-behavior="imageInfo">
        <svg class="icon--info-i" aria-label="Image info"><use xlink:href="#icon--info-i" /></svg>
      </button>
      <div class="m-article-header__info" id="image-info" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
        <p class="f-caption">{{ $img['info'] }}</p>
      </div>
      @endif
  </div>
</{{ $tag or 'header' }}>
