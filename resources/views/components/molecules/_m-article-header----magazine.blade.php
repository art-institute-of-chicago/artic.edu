<header class="m-article-header m-article-header--publication m-article-header--magazine" data-behavior="magazineHeader">
    <div class="m-article-header__img">
        @if (isset($images))
            @foreach ($images as $key => $image)
                @component('components.atoms._img')
                    @slot('image', $image)
                    @slot('class', 'img-hero-desktop ' . ($key === 0 ? 'is-slideshow-active' : null))
                    @slot('settings', array(
                        'srcset' => array(300,600,1000,1500,3000),
                        'sizes' => '100vw',
                    ))
                @endcomponent
                @component('components.atoms._img')
                    @slot('image', $imagesMobile[$key] ?? $image)
                    @slot('class', 'img-hero-mobile ' . ($key === 0 ? 'is-slideshow-active' : null))
                    @slot('settings', array(
                        'srcset' => array(300,600,1000,1500,3000),
                        'sizes' => '100vw',
                    ))
                @endcomponent
            @endforeach
        @endif
    </div>
    <div class="m-article-header__text{{ isset($credit) ? ' m-article-header__text--with-credit' : '' }}">
        <div class="m-article-header__logo">
            <svg class="icon--magazine-logo">
                <use xlink:href="#icon--magazine-logo"></use>
            </svg>
        </div>
        @if (isset($intro))
            @component('components.blocks._text')
                @slot('font', 'f-subheading-3')
                @slot('variation', 'm-article-header__intro')
                @slot('tag', 'div')
                {!! SmartyPants::defaultTransform($intro) !!}
            @endcomponent
        @endif
        @if (isset($title))
            <div class="m-article-header__title-lockup">
                @component('components.atoms._title')
                    @slot('tag','h1')
                    @slot('font', 'f-subheading-2')
                    @slot('itemprop','name')
                    @slot('title', $title)
                    @slot('title_display', $title_display ?? null)
                @endcomponent
            </div>
        @endif
        <div class="m-article-header__controls">
            <div class="m-article-header__pips">
                {{-- Populated via magazineHeader.js using template in script tag --}}
            </div>
            {{-- Similar to _media-play-pause-video, but without the behavior --}}
            <button class="m-article-header__play-pause btn btn--nonary btn--icon media-play-pause-video" aria-label="Pause animation">
                <svg aria-hidden="true" class="icon--pause">
                  <use xlink:href="#icon--pause"></use>
                </svg>
                <svg aria-hidden="true" class="icon--play">
                  <use xlink:href="#icon--play"></use>
                </svg>
            </button>
        </div>
        <script class="m-article-header__pip__template" type="text/template">
            <div class="m-article-header__pip">
                <svg class="icon--circle">
                    <use xlink:href="#icon--circle"></use>
                </svg>
            </div>
        </script>
        @if (!empty($credit))
            @component('components.molecules._m-info-trigger')
                @slot('isInverted', true)
                @slot('creditText', $credit)
            @endcomponent
        @endif
    </div>
</header>
