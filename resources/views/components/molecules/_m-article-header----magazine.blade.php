<{{ $tag ?? 'header' }} class="m-article-header m-article-header--publication m-article-header--magazine">
    <div class="m-article-header__img">
        @if ($img)
            @component('components.atoms._img')
                @slot('image', $img)
                @slot('settings', array(
                    'srcset' => array(300,600,1000,1500,3000),
                    'sizes' => '100vw',
                ))
            @endcomponent
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
                @slot('font', 'f-subheading-1')
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
        @if (!empty($credit))
            <button class="m-article-header__info-trigger m-article-header__info-trigger--inverse" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
                <svg class="icon--info" aria-label="Image credit"><use xlink:href="#icon--info" /></svg>
            </button>
            <div class="m-article-header__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
                <div class="f-caption">{!! $credit !!}</div>
            </div>
        @endif
    </div>
</{{ $tag ?? 'header' }}>
