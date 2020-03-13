<div class="o-editors-note">
    @component('components.blocks._text')
        @slot('font', 'f-tag')
        Editor’s Note
    @endcomponent

    <div class="o-editors-note__inner">
        @component('components.blocks._text')
            @slot('font', 'f-deck deck--black')
            @slot('tag', 'span')
            Issue {{ $issueNumber }}
        @endcomponent

        @component('components.blocks._text')
            @slot('font', 'f-deck deck--black')
            @slot('tag', 'span')
            {{ $title }}
        @endcomponent

        @component('components.blocks._text')
            @slot('font', 'f-deck')
            @slot('tag', 'span')
            {!! $description !!}
        @endcomponent
    </div>
</div>
