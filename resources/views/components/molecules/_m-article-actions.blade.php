<ul class="m-article-actions{{ (isset($variation)) ? ' '.$variation : '' }}">
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--icon'.((isset($articleType) and $articleType === 'editorial') ? ' btn--senary' : ''))
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('behavior','sharePage')
        @endcomponent
    </li>
    @if (!empty($icsLink))
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--calendar--24')
            @slot('dataAttributes', 'download')
            @slot('tag', 'a')
            @slot('href', '#')
        @endcomponent
    </li>
    @endif
    @if (isset($articleType) and $articleType !== 'exhibition' and $articleType !== 'exhibitionHistory' and $articleType !== 'video')
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--quaternary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
            @slot('behavior','printPage')
        @endcomponent
    </li>
    @endif
</ul>
