<div>{{-- See :nth-child(x) in _o-article.scss --}}

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

    <hr>

    <ul>
        @foreach($issues as $issue)
            <li>
                @component('components.atoms._tag')
                    @slot('href', $issue->title)
                    @slot('dataAttributes',' data-ajax-scroll-target="collection"')
                    @slot('variation', 'tag--journal tag--senary tag--w-image')
                    @slot('gtmAttributes', 'data-gtm-event="' . getUtf8Slug( $issue->title ) . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="journal-sidebar-issue"')
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
                    Issue {!! $issue->issue_number !!}
                    <br>
                    {!! $issue->present()->title !!}
                @endcomponent
            </li>
        @endforeach
    </ul>

    <hr class="u-hide@large u-hide@xlarge">

</div>
