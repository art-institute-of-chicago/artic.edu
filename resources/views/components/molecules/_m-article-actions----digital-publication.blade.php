<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar" {{ $isLogoAnimated ?? false ? 'data-sticky-animated-logo' : '' }}>

    <button class="g-sidebar__close" data-behavior="hideStickySidebar">
        <svg aria-hidden="true" class="icon--close" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1.5" d="M3 3l10 10M13 3L3 13"></path></svg>
    </button>

    <div class="m-article-actions--publication__logo">
        <a href="{!! $digitalPublication->present()->getCanonicalUrl() !!}">
            {!! $digitalPublication->sidebar_title_display !!}
        </a>
    </div>

    @php
        $sectionsForSidebar = $digitalPublication->present()->sectionsForSidebar($currentSection ?? null);
    @endphp

    @if (!empty($sectionsForSidebar))
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--publication-sidebar')
            @slot('titleFont', 'f-tag-2')
            @slot('items', $sectionsForSidebar)
        @endcomponent
    @endif

    <h2 class="sr-only" id="h-article-actions">Page Actions</h2>
    <ul class="m-article-actions" aria-labelledby="h-article-actions">
        <li class="m-article-actions__action">
            @component('components.atoms._btn')
                @slot('variation', 'btn--icon btn--senary')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
                @slot('behavior','sharePage')
                @slot('ariaLabel','Share page')
            @endcomponent
        </li>
        @if (isset($pdfDownloadPath))
            <li class="m-article-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--icon')
                    @slot('font', '')
                    @slot('tag', 'a')
                    @slot('href', $pdfDownloadPath)
                    @slot('icon', 'icon--download--24')
                    @slot('ariaLabel','Download PDF')
                @endcomponent
            </li>
        @endif
        @if (isset($citeAs))
            <li class="m-article-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--icon btn--septenary')
                    @slot('font', '')
                    @slot('tag', 'a')
                    @slot('href', '#h-how-to-cite')
                    @slot('icon', 'icon--citation--24')
                    @slot('ariaLabel','Show how to cite')
                @endcomponent
            </li>
        @endif
    </ul>

    <div>
        <hr>
        <a href="{!! route('collection.publications.digital-publications') !!}" class="f-link">More Digital Publications<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a>
    </div>
</div>

<div class="o-sticky-sidebar__placeholder"></div>
