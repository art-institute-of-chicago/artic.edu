<{{ $tag or 'header' }} class="m-article-header m-article-header--generic{{ (isset($img)) ? ' m-article-header--generic-w-img' : ''}}{{ (!isset($breadcrumb)) ? ' m-article-header--generic-no-breadcrumb' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="blurMyBackground">
    @if ($img)
    <div class="m-article-header__img" data-blur-img>
        @component('components.atoms._img')
            @slot('src', $img['src'])
            @slot('width', $img['width'])
            @slot('height', $img['height'])
        @endcomponent
    </div>
    @endif
  <div class="m-article-header__text">
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            {{ $title }}
        @endcomponent
      @endif
  </div>
  @if (isset($breadcrumb))
      <ul class="m-article-header__breadcrumb" data-blur-clip-to>
          @foreach ($breadcrumb as $link)
              @if ($loop->last)
                  <li class="f-secondary">
                      {{ $link['label'] }}
                  </li>
              @else
                  <li class="f-secondary">
                      @component('components.atoms._arrow-link')
                          @slot('font','f-null')
                          @slot('href',$link['href'])
                          {{ $link['label'] }}
                      @endcomponent
                  </li>
              @endif
          @endforeach
      </ul>
  @endif
</{{ $tag or 'header' }}>
