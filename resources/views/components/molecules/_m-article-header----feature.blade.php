@if ($bgcolor ?? false)
    <style>
        .{{ (isset($variation)) ? $variation : 'm-article-header--feature' }} .m-article-header__text::before {
            background-color: {{ $bgcolor }};
        }
    </style>
@endif
<{{ $tag ?? 'header' }} class="m-article-header m-article-header--feature{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="blurMyBackground">
    <div class="m-article-header__img"{{ (isset($variation) && $variation != 'm-article-header--digital-publication') ? ' data-blur-img' : '' }}>
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
    <div class="m-article-header__text" data-blur-clip-to>
        @if (isset($title))
            @component('components.atoms._title')
                @slot('tag','h1')
                @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
                @slot('itemprop','name')
                @slot('title', $title)
                @slot('title_display', $title_display ?? null)
            @endcomponent
            @if (isset($subtitle_display))
                <h2 class="subtitle f-headline-editorial">
                    {!! $subtitle_display !!}
                </h2>
            @endif
        @endif

        {{-- Preview dates --}}
        @component('components.organisms._o-preview-dates')
            @slot('previewDateStart', $previewDateStart ?? null)
            @slot('previewDateEnd', $previewDateEnd ?? null)
        @endcomponent

        {{-- Regular dates --}}
        @component('components.organisms._o-public-dates')
            @slot('tag', 'p')
            @slot('formattedDate', $formattedDate ?? null)
            @slot('dateStart', $dateStart ?? null)
            @slot('dateEnd', $dateEnd ?? null)
            @slot('date', $date ?? null)
        @endcomponent

        @if (isset($type))
            @component('components.atoms._type')
                @slot('tag','p')
                {{ $type }}
            @endcomponent
        @endif

        @if ((isset($credit) and !empty($credit)) or ($img and isset($img['credit']) and $img['credit'] !== ""))
            @component('components.molecules._m-info-trigger')
                @slot('creditUrl', $creditUrl ?? $img['creditUrl'] ?? null)
                @slot('creditText', $credit ?? $img['credit'] ?? null)
            @endcomponent
        @endif
    </div>
</{{ $tag ?? 'header' }}>
