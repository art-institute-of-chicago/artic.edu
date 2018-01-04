<{{ $tag or 'header' }} class="m-article-header m-article-header--generic{{ (isset($variation)) ? ' '.$variation : '' }}">
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
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            {{ $title }}
        @endcomponent
      @endif
      @if (isset($breadcrumb))
          @if (isset($img))
          <ul class="m-article-header__breadcrumb" style="background-image: url({{ $img['src'] }});">
          @else
          <ul class="m-article-header__breadcrumb">
          @endif
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
  </div>
</{{ $tag or 'header' }}>
