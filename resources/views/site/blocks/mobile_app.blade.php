<div class="m-mobile-block">
    @component('components.atoms._hr')
        @slot('variation', 'm-mobile-block__hr--top')
    @endcomponent

    <div class="m-mobile-block__wrapper">
        <div class="m-mobile-block__icon-wrapper">
            <svg aria-hidden="true" class="icon--mobile-app">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--mobile-app"></use>
            </svg>
        </div>
        <div class="m-mobile-block__text-wrapper">
            @component('components.blocks._text')
                @slot('tag', 'div')
                @slot('font', 'f-list-1--dense')
                {!! $block->input('callout') !!}
            @endcomponent
        </div>
    </div>

    @component('components.atoms._hr')
        @slot('variation', 'm-mobile-block__hr--bottom')
    @endcomponent
</div>
