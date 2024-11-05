<div class="o-sticky-sidebar__sticker" data-behavior="stickySidebar">

    <div class="m-article-actions--publication__logo u-hide@xsmall u-hide@small u-hide@medium">
        <a href="{!! route('magazine-issues.latest') !!}">
            <svg class="icon--magazine-logo">
                <use xlink:href="#icon--magazine-logo"></use>
            </svg>
        </a>
    </div>

    <p class="m-article-actions--publication__text f-secondary">The Art Institute magazine is a quarterly publication offering members an in-depth look at our collection, exhibitions, and ongoing initiatives.</p>

    <hr>

<p class="m-article-actions--publication__text f-secondary"><a href="https://sales.artic.edu/memberships" data-gtm-event-category="nav-link" data-gtm-event="Membership">Become a member</a> or <a href="https://sales.artic.edu/Profile/VerifyMembership" data-gtm-event-category="nav-link" data-gtm-event="Verify Membership">renew your membership</a>.</p>

    <hr>

    <div class="m-article-actions--publication__text f-secondary">
        <h3 id="h-nav-magazine-social">Stay connected</h4>
        <ul class="f-secondary" aria-labelledby="h-nav-magazine-social">
            <li><a href="{{ $_pages['follow-facebook'] }}" data-gtm-event="facebook" data-gtm-event-category="follow" target="_blank">Facebook</a></li>
            <li><a href="{{ $_pages['follow-twitter'] }}" data-gtm-event="twitter" data-gtm-event-category="follow" target="_blank">Twitter</a></li>
            <li><a href="{{ $_pages['follow-instagram'] }}" data-gtm-event="instagram" data-gtm-event-category="follow" target="_blank">Instagram</a></li>
            <li><a href="{{ $_pages['follow-youtube'] }}" data-gtm-event="youtube" data-gtm-event-category="follow" target="_blank">YouTube</a></li>
        </ul>
    </div>

    @if (isset($issues))
        <hr>
        @component('components.organisms._o-accordion-tree')
            @slot('variation', 'o-accordion--magazine-issue-archive')
            @slot('titleFont', 'f-tag-2')
            @slot('items', $issues)
            @slot('active', true)
        @endcomponent
    @endif

    <hr class="u-hide@large u-hide@xlarge">

</div>

<div class="o-sticky-sidebar__placeholder"></div>
