@php
    $variation = isset($variation) ? $variation : '';
    $variation = (isset($editorial) and $editorial) ? $variation.' m-article-header--editorial' : $variation;
@endphp
@if (isset($headerType) and $headerType === 'feature')
    {{-- Feature header --}}
    @component('components.molecules._m-article-header----feature')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('formattedDate', $formattedDate ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart ?? null)
        @slot('dateEnd', $dateEnd ?? null)
        @slot('type', $type ?? null)
        @slot('img', $img ?? null)
        @slot('credit', $credit ?? null)
        @slot('creditUrl', $creditUrl ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'super-hero')
    {{-- Super Hero header --}}
    @component('components.molecules._m-article-header----super-hero')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart)
        @slot('dateEnd', $dateEnd)
        @slot('type', $type ?? null)
        @slot('intro', $intro ?? null)
        @slot('img', $img ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'hero')
    {{-- Hero header --}}
    @component('components.molecules._m-article-header----hero')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('articleType', $type ?? null)
        @slot('img', $img ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'generic')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----generic')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('img', $img ?? null)
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'gallery')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----gallery')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('images', $galleryImages ?? null)
        @slot('isZoomable', $isZoomable ?? null)
        @slot('isPublicDomain', $isPublicDomain ?? null)
        @slot('maxZoomWindowSize', $maxZoomWindowSize ?? null)
        @slot('nextArticle', $nextArticle ?? null)
        @slot('prevArticle', $prevArticle ?? null)
    @endcomponent
@else
    {{-- Default header --}}
    @component('components.molecules._m-article-header----default')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('formattedDate', $formattedDate ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart ?? null)
        @slot('dateEnd', $dateEnd ?? null)
        @slot('type', $type ?? null)
    @endcomponent
@endif
