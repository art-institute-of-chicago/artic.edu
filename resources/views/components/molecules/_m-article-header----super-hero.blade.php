<{{ $tag ?? 'header' }} class="m-article-header m-article-header--super-hero{{ (isset($variation)) ? ' '.$variation : '' }}">
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
                @slot('tag','h1')
                @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-display-2')
                @slot('itemprop','name')
                @slot('title', $title)
                @slot('title_display', $title_display ?? null)
            @endcomponent
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

        @if (isset($intro))
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font','f-deck')
                @slot('variation', 'm-article-header__intro')
                @slot('tag', 'div')
                {!! SmartyPants::defaultTransform($intro) !!}
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
