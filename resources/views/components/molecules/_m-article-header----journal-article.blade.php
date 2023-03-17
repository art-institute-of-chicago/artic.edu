<header class="m-article-header m-article-header--journal-article">
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
        @if (isset($title))
            @component('components.atoms._title')
                @slot('tag', 'h1')
                @slot('font', 'f-headline-editorial')
                @slot('itemprop', 'name')
                @slot('title', $title)
                @slot('title_display', $title_display ?? null)
            @endcomponent
        @endif
        @if (!empty($credit))
            @component('components.molecules._m-info-trigger')
                @slot('isInverted', true)
                @slot('creditText', $credit)
            @endcomponent
        @endif
    </div>
</header>
