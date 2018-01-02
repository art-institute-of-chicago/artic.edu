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
            @slot('font','f-headline')
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
  </div>
</{{ $tag or 'header' }}>
