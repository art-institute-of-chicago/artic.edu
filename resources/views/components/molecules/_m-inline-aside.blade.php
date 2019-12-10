<aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}">
    @component('components.atoms._hr')
    @endcomponent
    @if (isset($title))
        @component('components.blocks._text')
            @slot('font', ($titleFont ?? 'f-module-title-1'))
            @slot('tag', ($titleTag ?? 'h4'))
            {!! $title_display ?? $title !!}
        @endcomponent
    @endif
    {{ $slot }}
</aside>
