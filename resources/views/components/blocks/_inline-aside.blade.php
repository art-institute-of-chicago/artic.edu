<aside class="o-article__inline-aside">
    @if (isset($title))
        <hr>
        @component('components.blocks._text')
            @slot('font', ($titleFont ?? 'f-subheading-1'))
            @slot('tag', ($titleTag ?? 'h4'))
            {{ $title }}
        @endcomponent
    @endif
    {{ $slot }}
</aside>
