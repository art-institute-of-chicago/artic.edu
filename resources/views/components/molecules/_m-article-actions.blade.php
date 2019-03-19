<div>{{-- See :nth-child(x) in _o-article.scss --}}
<h2 class="sr-only" id="h-article-actions">Share</h2>
<ul class="m-article-actions{{ (isset($variation)) ? ' '.$variation : '' }}" aria-labelledby="h-article-actions">
    @if (empty($hideShare))
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--icon'.((isset($articleType) and $articleType === 'editorial') ? ' btn--senary' : ''))
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('behavior','sharePage')
            @slot('ariaLabel','Share page')
        @endcomponent
    </li>
    @endif
    @if (!empty($icsLink))
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--calendar--24')
            @slot('dataAttributes', 'download')
            @slot('tag', 'a')
            @slot('href', $icsLink)
            @slot('ariaLabel','Add to your calendar (ics file)')
        @endcomponent
    </li>
    @endif
    @if (empty($articleType) or (isset($articleType) and $articleType !== 'exhibition' and $articleType !== 'exhibitionHistory' and $articleType !== 'video'))
    <li class="m-article-actions__action u-hide@small-">
        @component('components.atoms._btn')
            @slot('variation', 'btn--quaternary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
            @slot('behavior','printPage')
            @slot('ariaLabel','Print page')
        @endcomponent
    </li>
    @endif
</ul>
</div>
