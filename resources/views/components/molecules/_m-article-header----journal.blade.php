<header class="m-article-header m-article-header--publication m-article-header--journal">
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
  <div class="m-article-header__text{{ isset($credit) ? ' m-article-header__text--with-credit' : '' }}">
      <div class="m-article-header__logo">
        <svg class="icon--journal-logo">
          <use xlink:href="#icon--journal-logo"></use>
        </svg>
      </div>
      @if (isset($intro))
        @component('components.blocks._text')
            @slot('font','f-deck')
            @slot('variation', 'm-article-header__intro')
            @slot('tag', 'div')
            {!! SmartyPants::defaultTransform($intro) !!}
        @endcomponent
      @endif
      @if (isset($issueNumber) || isset($title))
        <div class="m-article-header__title-lockup">
          @if (isset($issueNumber))
            @component('components.blocks._text')
                @slot('font','f-subheading-2')
                @slot('variation', 'm-article-header__issue-number')
                @slot('tag', 'span')
                Issue {!! SmartyPants::defaultTransform($issueNumber) !!}
            @endcomponent
          @endif
          @if (isset($title))
            @component('components.atoms._title')
                @slot('tag','h1')
                @slot('font', 'f-subheading-2')
                @slot('itemprop','name')
                @slot('title', $title)
                @slot('title_display', $title_display ?? null)
            @endcomponent
          @endif
        </div>
      @endif
      @if (!empty($credit))
            @component('components.molecules._m-info-trigger')
                @slot('isInverted', true)
                @slot('creditText', $credit)
            @endcomponent
      @endif
  </div>
</header>
