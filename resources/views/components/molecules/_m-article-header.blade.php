@if (isset($headerType) and $headerType === 'feature')
    {{-- Feature header --}}
    @component('components.molecules._m-article-header----feature')
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('date', $date ?? null)
        @slot('type', $type ?? null)
        @slot('img', $img ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'hero')
    {{-- Hero header --}}
    @component('components.molecules._m-article-header----hero')
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('date', $date ?? null)
        @slot('type', $type ?? null)
        @slot('intro', $intro ?? null)
        @slot('img', $img ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'generic')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----generic')
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('img', $img ?? null)
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent
@else
    {{-- Default header --}}
    @component('components.molecules._m-article-header----default')
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('date', $date ?? null)
        @slot('type', $type ?? null)
    @endcomponent
@endif
