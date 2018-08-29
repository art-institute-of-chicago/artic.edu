<{{ $tag ?? 'div' }} class="m-featured-results{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($title))
        @component('components.blocks._text')
            @slot('font', ($titleFont ?? 'f-tag'))
            @slot('tag', ($titleTag ?? 'h2'))
            @slot('variation', 'm-featured-results__title')
            {!! $title_display ?? $title !!}
        @endcomponent
    @endif
    {{ $slot }}
</{{ $tag ?? 'div' }}>
