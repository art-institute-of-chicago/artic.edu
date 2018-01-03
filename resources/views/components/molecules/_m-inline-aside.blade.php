<aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}">
    <span class="hr"></span>
    @if (isset($title))
        @component('components.blocks._text')
            @slot('font', ($titleFont ?? 'f-module-title-1'))
            @slot('tag', ($titleTag ?? 'h4'))
            {{ $title }}
        @endcomponent
    @endif
    {{ $slot }}
</aside>
