<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar">

    <button class="g-sidebar__close" data-behavior="hideStickySidebar">
        <svg aria-hidden="true" class="icon--close" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1.5" d="M3 3l10 10M13 3L3 13"></path></svg>
    </button>

    <div class="m-article-actions--publication__logo">
        <a href="/journal">
            <svg class="icon--journal-logo">
                <use xlink:href="#icon--journal-logo"></use>
            </svg>
        </a>
    </div>

    @if (!empty($item->issue))
        @component('components.molecules._m-article-actions----journal__issues')
            @slot('issues', [$item->issue])
        @endcomponent
    @endif

    @if (!empty($item->present()->articlesForSidebar()))
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--publication-sidebar')
            @slot('titleFont', 'f-tag-2')
            @slot('items', $item->present()->articlesForSidebar())
        @endcomponent
    @endif

    <h2 class="sr-only" id="h-article-actions">Article Actions</h2>
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
        @if (!empty($item->present()->pdfDownloadPath()))
            <li class="m-article-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--icon')
                    @slot('font', '')
                    @slot('tag', 'a')
                    @slot('href', $item->present()->pdfDownloadPath())
                    @slot('icon', 'icon--download--24')
                    @slot('ariaLabel','Download PDF')
                @endcomponent
            </li>
        @endif
        @if ($item->cite_as)
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
</div>

<div class="o-sticky-sidebar__placeholder"></div>
