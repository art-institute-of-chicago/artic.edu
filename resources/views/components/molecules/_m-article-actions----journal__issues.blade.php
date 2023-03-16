{{-- _m-article-actions----magazine-issue also has this, separately, since it's different enough --}}
<ul class="m-article-actions--journal__issues">
    @foreach($issues as $issue)
        <li>
            @component('components.atoms._tag')
                @slot('href', route('issues.show', [
                    'issueNumber' => $issue->issue_number,
                    'slug' => $issue->getSlug(),
                ]))
                @slot('variation', 'tag--journal tag--senary tag--w-image')
                @slot('gtmAttributes', 'data-gtm-event="' . StringHelpers::getUtf8Slug( $issue->title ) . '" data-gtm-event-category="journal-sidebar-issue"')
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
