<{{ $tag or 'header' }} class="m-article-header{{ (isset($headerType)) ? ' m-article-header--'.$headerType : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">

  @if (isset($headerType) and ($headerType == 'feature' or $headerType == 'hero' or $headerType == 'generic'))
    <div class="m-article-header__img">
        @if (isset($img))
          @component('components.atoms._img')
              @slot('src', $img['src'])
              @slot('width', $img['width'])
              @slot('height', $img['height'])
          @endcomponent
        @endif
    </div>
  @endif

  @if (isset($headerType) and ($headerType == 'feature'))
    <div class="m-article-header__text" style="background-image: url({{ $img['src'] }});">
  @endif

  @if (isset($headerType) and ($headerType == 'hero' or $headerType == 'generic'))
    <div class="m-article-header__text">
  @endif

  @if (isset($title))
    @component('components.atoms._title')
        @slot('tag','h1')
        @slot('font',(isset($headerType) and ($headerType == 'hero')) ? 'f-display-2' : 'f-headline')
        {{ $title }}
    @endcomponent
  @endif

  @if (!isset($headerType) or ($headerType != 'generic'))
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
  @endif

  @if (isset($intro) and isset($headerType) and ($headerType == 'hero'))
    @component('components.atoms._hr')
    @endcomponent
    @component('components.blocks._text')
        @slot('font','f-deck')
        @slot('variation', 'm-article-header__intro')
        {{ $intro }}
    @endcomponent
  @endif

  @if (isset($breadcrumb) and isset($headerType) and ($headerType == 'generic'))
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

  @if (isset($headerType) and ($headerType == 'feature' or $headerType == 'hero' or $headerType == 'generic'))
    </div>
  @endif
</{{ $tag or 'header' }}>
