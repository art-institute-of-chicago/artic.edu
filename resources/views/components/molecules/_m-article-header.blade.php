@if (isset($headerType) and $headerType === 'feature')
    {{-- Feature header --}}
    @component('components.molecules._m-article-header----feature')
        @slot('variation', $variation)
        @slot('title', $title)
        @slot('date', $date)
        @slot('type', $type)
        @slot('img', $img)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'hero')
    {{-- Hero header --}}
    @component('components.molecules._m-article-header----hero')
        @slot('variation', $variation)
        @slot('title', $title)
        @slot('date', $date)
        @slot('type', $type)
        @slot('intro', $intro)
        @slot('img', $img)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'generic')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----generic')
        @slot('variation', $variation)
        @slot('title', $title)
        @slot('img', $img)
        @slot('breadcrumb', $breadcrumb)
    @endcomponent
@else
    {{-- Default header --}}
    @component('components.molecules._m-article-header----default')
        @slot('variation', $variation)
        @slot('title', $title)
        @slot('date', $date)
        @slot('type', $type)
    @endcomponent
@endif
