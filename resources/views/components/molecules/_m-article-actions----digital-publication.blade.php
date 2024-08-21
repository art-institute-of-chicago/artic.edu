<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar" {{ $isLogoAnimated ?? false ? 'data-sticky-animated-logo' : '' }}>

    <button class="g-sidebar__close" data-behavior="hideStickySidebar">
        <svg aria-hidden="true" class="icon--close" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1.5" d="M3 3l10 10M13 3L3 13"></path></svg>
    </button>

    <div class="m-article-actions--publication__logo">
        <a href="{!! $digitalPublication->present()->getCanonicalUrl() !!}">
            {!! $digitalPublication->header_title_display !!}
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
</div>

<div class="o-sticky-sidebar__placeholder"></div>
