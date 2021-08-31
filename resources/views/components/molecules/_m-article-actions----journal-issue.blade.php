<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar">

    <div class="m-article-actions--publication__logo u-hide@xsmall u-hide@small u-hide@medium">
        <a href="/journal">
            <svg class="icon--journal-logo">
                <use xlink:href="#icon--journal-logo"></use>
            </svg>
        </a>
    </div>

    <p class="m-article-actions--publication__text f-secondary">The <i>Art Institute Review</i> is dedicated to innovative object-centered scholarship and is published twice a year. <a href="/journal">Learn more.</a></p>

    @if (isset($issues) && $issues->count() > 1)
        @component('components.molecules._m-search-bar')
            @slot('placeholder','Search articles')
            @slot('name', 'journal-search-mobile')
            @slot('value', request('q'))
            @slot('action', route('collection'))
            @slot('gtmAttributes', 'data-gtm-event="click" data-gtm-event-category="journal f-search"')
        @endcomponent

        <hr>

        @component('components.molecules._m-article-actions----journal__issues')
            @slot('issues', $issues)
        @endcomponent
    @else
        <hr class="hr--no-archive">
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
        @if (!empty($citeAs))
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

    <hr class="u-hide@large u-hide@xlarge">

</div>

<div class="o-sticky-sidebar__placeholder"></div>
