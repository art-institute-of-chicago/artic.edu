<div class="o-sticky-sidebar__sticker"  data-behavior="stickySidebar" data-sticky-offset="30">{{-- See :nth-child(x) in _o-article.scss --}}

    <div class="m-article-actions--journal__logo u-hide@xsmall u-hide@small u-hide@medium">
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

    <hr class="u-hide@large u-hide@xlarge">

</div>

<div class="o-sticky-sidebar__placeholder"></div>
