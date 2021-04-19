<header class="m-article-header m-article-header--journal-article">
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
            <button class="m-info-trigger m-info-trigger--inverse" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
                <svg class="icon--info" aria-label="Image credit"><use xlink:href="#icon--info" /></svg>
            </button>
            <div class="m-info-trigger__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
                <div class="f-caption">{!! $credit !!}</div>
            </div>
        @endif
    </div>
</header>
