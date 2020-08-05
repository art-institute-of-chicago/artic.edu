<div class="o-editors-note o-editors-note--magazine">
    @component('components.atoms._link')
        @slot('font', '')
        @slot('href', $articleLink)
        @slot('gtmAttributes', $gtmAttributes)

        @component('components.blocks._text')
            @slot('font', 'f-tag')
            @slot('variation', 'o-editors-note__tag')
            To Our Community
        @endcomponent

        <div class="o-editors-note__inner">
            <div class="o-editors-note__title-lockup f-deck">
                {!! $description !!}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
            </div>
        </div>

        @if (isset($authorDisplay))
            <div class="o-editors-note__author f-body-editorial">
                ⁠—{!! $authorDisplay !!}
            </div>
        @endif
    @endcomponent
</div>
