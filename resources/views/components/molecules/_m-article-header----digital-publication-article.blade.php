@if ($bgcolor ?? false)
    <style>
        .m-article-header--digital-publication-article ~ .m-article-header__text::before,
        .m-article-actions--publication__logo {
            background-color: {{ isset($bgcolor) ? $bgcolor : null  }};
        }
    </style>
@endif

<header
    class="m-article-header m-article-header--feature m-article-header--digital-publication-article"
    data-behavior="contrastText"
    data-background-color="{{ isset($bgcolor) ? $bgcolor : null }}"
>
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
        @if (($variation ?? '') !== 'm-article-header--digital-publication')
            @if ((isset($credit) and !empty($credit)) or ($img and isset($img['credit']) and $img['credit'] !== ""))
                @component('components.molecules._m-info-trigger')
                    @slot('creditUrl', $creditUrl ?? $img['creditUrl'] ?? null)
                    @slot('creditText', $credit ?? $img['credit'] ?? null)
                @endcomponent
            @endif
        @endif
    </div>

    @if (($variation ?? '') === 'm-article-header--digital-publication')
        @if ((isset($credit) and !empty($credit)) or ($img and isset($img['credit']) and $img['credit'] !== ""))
            @component('components.molecules._m-info-trigger')
                @slot('creditUrl', $creditUrl ?? $img['creditUrl'] ?? null)
                @slot('creditText', $credit ?? $img['credit'] ?? null)
            @endcomponent
        @endif
    @endif

    <div class="m-article-actions--publication__logo u-show@medium- contrast-text">
        {!! $pub_title_display ?? $pub_title !!}
    </div>
</header>
