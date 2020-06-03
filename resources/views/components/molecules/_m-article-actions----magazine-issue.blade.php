<div class="o-sticky-sidebar__sticker"  data-behavior="stickySidebar" data-sticky-offset="30">{{-- See :nth-child(x) in _o-article.scss --}}

    <div class="m-article-actions--journal__logo u-hide@xsmall u-hide@small u-hide@medium">
        <a href="/journal">
            <svg class="icon--magazine-logo">
                <use xlink:href="#icon--magazine-logo"></use>
            </svg>
        </a>
    </div>

    <p class="m-article-actions--journal__blurb f-secondary">The Member Magazine is a curated selection of exhibitions, events, and behind-the-scenes at the Art Institute of Chicago. The magazine comes out 6 times a year.</p>

    <hr>

    <p class="m-article-actions--journal__blurb f-secondary"><a href="https://sales.artic.edu/memberships">Become a member</a> or <a href="https://sales.artic.edu/Profile/VerifyMembership">renew your membership</a>.</p>

    <hr>

    <div class="m-article-actions--journal__blurb f-secondary">
        <h3 id="h-nav-magazine-social">Stay connected</h4>
        <ul class="f-secondary" aria-labelledby="h-nav-magazine-social">
            <li><a href="{{ $_pages['follow-facebook'] }}" data-gtm-event="facebook" data-gtm-event-action="{{$seo->title}}" data-gtm-event-category="follow" target="_blank">Facebook</a></li>
            <li><a href="{{ $_pages['follow-twitter'] }}" data-gtm-event="twitter" data-gtm-event-action="{{$seo->title}}" data-gtm-event-category="follow" target="_blank">Twitter</a></li>
            <li><a href="{{ $_pages['follow-instagram'] }}" data-gtm-event="instagram" data-gtm-event-action="{{$seo->title}}" data-gtm-event-category="follow" target="_blank">Instagram</a></li>
            <li><a href="{{ $_pages['follow-youtube'] }}" data-gtm-event="youtube" data-gtm-event-action="{{$seo->title}}" data-gtm-event-category="follow" target="_blank">YouTube</a></li>
        </ul>
    </div>

    <hr>

    <ul class="m-article-actions--journal__issues">
        @foreach($issues as $issue)
            <li>
                @component('components.atoms._tag')
                    @slot('href', $issue->title)
                    @slot('dataAttributes',' data-ajax-scroll-target="collection"')
                    @slot('variation', 'tag--magazine tag--senary tag--w-image')
                    @slot('gtmAttributes', 'data-gtm-event="' . getUtf8Slug( $issue->title ) . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="magazine-sidebar-issue"')
                    @if (!empty($issue->imageFront('hero', 'default')))
                        @component('components.atoms._img')
                            @slot('image', $issue->imageFront('hero', 'default'))
                            @slot('settings', array(
                                'fit' => 'crop',
                                'ratio' => '1:1',
                                'srcset' => array(30,60),
                                'sizes' => '60px',
                            ))
                        @endcomponent
                    @endif
                    {!! $issue->present()->title !!}
                @endcomponent
            </li>
        @endforeach
    </ul>

    <hr class="u-hide@large u-hide@xlarge">

</div>

<div class="o-sticky-sidebar__placeholder"></div>
