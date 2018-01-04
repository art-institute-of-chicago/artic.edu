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
  </div>
</{{ $tag or 'header' }}>
