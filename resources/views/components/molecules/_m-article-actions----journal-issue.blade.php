<div class="o-sticky-sidebar__sticker"  data-behavior="stickySidebar" data-sticky-offset="30">{{-- See :nth-child(x) in _o-article.scss --}}

    <div class="m-article-actions--journal__logo u-hide@xsmall u-hide@small u-hide@medium">
        <a href="/journal">
            <svg class="icon--journal-logo">
                <use xlink:href="#icon--journal-logo"></use>
            </svg>
        </a>
    </div>

    <p class="m-article-actions--journal__blurb f-secondary">The Art Institute Review is dedicated to innovative object-centered scholarship and is published twice a year. <a href="/journal">Learn more.</a></p>

    @component('components.molecules._m-search-bar')
        @slot('placeholder','Search articles')
        @slot('name', 'journal-search-mobile')
        @slot('value', request('q'))
        @slot('action', route('collection'))
        @slot('gtmAttributes', 'data-gtm-event="click" data-gtm-event-category="journal f-search"')
    @endcomponent

    @if (!empty($issues))
        <hr>

        @component('components.molecules._m-article-actions----journal__issues')
            @slot('issues', $issues)
        @endcomponent
    @endif

    <hr class="u-hide@large u-hide@xlarge">

</div>

<div class="o-sticky-sidebar__placeholder"></div>
