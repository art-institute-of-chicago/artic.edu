@if ($bgcolor ?? false)
    <style>
        .m-article-header--digital-publication-article ~ .m-article-header__text::before,
        .m-article-actions--publication__logo {
            background-color: {{ $bgcolor }};
        }
    </style>
@endif

<header
    class="m-article-header m-article-header--feature m-article-header--digital-publication-article"
    data-behavior="contrastText"
    data-background-color="{{ $bgcolor }}"
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
    </div>
    <div class="m-article-actions--publication__logo u-show@medium-">
        {!! $pub_title_display ?? $pub_title !!}
    </div>
</header>
