<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar" {{ $isLogoAnimated ?? false ? 'data-sticky-animated-logo' : '' }}>

    <button class="g-sidebar__close" data-behavior="hideStickySidebar">
        <svg aria-hidden="true" class="icon--close" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1.5" d="M3 3l10 10M13 3L3 13"></path></svg>
    </button>

    <div class="m-article-actions--publication__logo u-show@large+">
        <a href="{!! $digitalPublication->present()->getCanonicalUrl() !!}" class="contrast-text">
            {!! $digitalPublication->title_display ?? $digitalPublication->title !!}
        </a>
    </div>

    @php
        $topLevelArticles = $digitalPublication->present()->topLevelArticles();
    @endphp

    @if (!empty($topLevelArticles))
        @component('components.organisms._o-table-of-contents')
            @slot('variation', 'o-accordion--publication-sidebar')
            @slot('titleFont', 'f-tag-2')
            @slot('items', $topLevelArticles)
            @slot('currentArticle', $currentArticle ?? null)
        @endcomponent
    @endif

    <ul class="m-article-actions{{ (isset($variation)) ? ' '.$variation : '' }}" aria-labelledby="h-article-actions{{ (isset($variation)) ? $variation : '' }}">

        <li class="m-article-actions__action">
            @component('components.atoms._btn')
                @slot('variation', 'btn--icon'.((isset($articleType) and $articleType === 'editorial') ? ' btn--senary' : '').((isset($btnVariation)) ? ' '.$btnVariation : ''))
                @slot('font', '')
                @slot('icon', 'icon--share--24')
                @slot('behavior','sharePage')
                @slot('ariaLabel','Share page')
                @slot('dataAttributes',' data-share-url="' . ($shareUrl ?? '') . '"')
            @endcomponent
        </li>

        @if (isset($pdfDownloadPath))
            <li class="m-article-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--icon ' . ((isset($btnVariation)) ? ' '.$btnVariation : ''))
                    @slot('font', '')
                    @slot('tag', 'a')
                    @slot('href', $pdfDownloadPath)
                    @slot('icon', 'icon--download--24')
                    @slot('ariaLabel','Download PDF')
                @endcomponent
            </li>
        @endif

    </ul>
</div>

<div class="o-sticky-sidebar__placeholder"></div>
