<{{ $tag ?? 'header' }} class="m-article-header m-article-header--hero{{ (isset($variation)) ? ' '.$variation : '' }}">
  <div class="m-article-header__img">
      @if ($img)
        @component('components.atoms._img')
            @slot('image', $img)
            @slot('class', 'img-hero-desktop')
            @slot('settings', array(
                'srcset' => array(300,600,1000,1500,3000),
                'sizes' => '100vw',
            ))
        @endcomponent
        @component('components.atoms._img')
            @slot('image', !empty($imgMobile) ? $imgMobile : $img)
            @slot('class', 'img-hero-mobile')
            @slot('settings', array(
                'srcset' => array(300,600,1000,1500,3000),
                'sizes' => '100vw',
            ))
        @endcomponent
      @endif
  </div>
  <div class="m-article-header__text">
      @if (isset($articleType))
        @component('components.atoms._title')
            @slot('tag','p')
            @slot('font', 'f-tag-2')
            {{ ucfirst($articleType) }}
        @endcomponent
      @endif
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', 'f-display-3')
            @slot('itemprop','name')
            @slot('title', $title)
            @slot('title_display', $title_display ?? null)
        @endcomponent
      @endif
      @if ((isset($credit) and !empty($credit)) or ($img and isset($img['credit']) and $img['credit'] !== ""))
        @component('components.molecules._m-info-trigger')
            @slot('creditUrl', $img['creditUrl'] ?? null)
            @slot('creditText', $credit ?? $img['credit'] ?? null)
        @endcomponent
      @endif
  </div>
</{{ $tag ?? 'header' }}>
