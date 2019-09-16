@php
    $variation = isset($variation) ? $variation : '';
    if (isset($editorial) and $editorial) {
        $date = null;
        $variation .= ' m-article-header--editorial';
    }
@endphp
@if (isset($headerType) and $headerType === 'feature')
    {{-- Feature header --}}
    @component('components.molecules._m-article-header----feature')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('title_display', $title_display ?? null)
        @slot('formattedDate', $formattedDate ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart ?? null)
        @slot('dateEnd', $dateEnd ?? null)
        @slot('previewDateStart', $previewDateStart ?? null)
        @slot('previewDateEnd', $previewDateEnd ?? null)
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
        @slot('title_display', $title_display ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart)
        @slot('dateEnd', $dateEnd)
        @slot('previewDateStart', $previewDateStart ?? null)
        @slot('previewDateEnd', $previewDateEnd ?? null)
        @slot('type', $type ?? null)
        @slot('intro', $intro ?? null)
        @slot('img', $img ?? null)
        @slot('credit', $credit ?? null)
        @slot('creditUrl', $creditUrl ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'hero')
    {{-- Hero header --}}
    @component('components.molecules._m-article-header----hero')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('title_display', $title_display ?? null)
        @slot('articleType', $type ?? null)
        @slot('img', $img ?? null)
        @slot('credit', $credit ?? null)
        @slot('creditUrl', $creditUrl ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'generic')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----generic')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('title_display', $title_display ?? null)
        @slot('img', $img ?? null)
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent
@elseif (isset($headerType) and $headerType === 'gallery')
    {{-- Generic header --}}
    @component('components.molecules._m-article-header----gallery')
        @slot('title', $title ?? null)
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('images', $galleryImages ?? null)
        @slot('isZoomable', $isZoomable ?? null)
        @slot('isPublicDomain', $isPublicDomain ?? null)
        @slot('maxZoomWindowSize', $maxZoomWindowSize ?? null)
        @slot('prevNextObject', $prevNextObject ?? null)
    @endcomponent
@else
    {{-- Default header --}}
    @component('components.molecules._m-article-header----default')
        @slot('editorial', $editorial ?? null)
        @slot('variation', $variation ?? null)
        @slot('title', $title ?? null)
        @slot('title_display', $title_display ?? null)
        @slot('formattedDate', $formattedDate ?? null)
        @slot('date', $date ?? null)
        @slot('dateStart', $dateStart ?? null)
        @slot('dateEnd', $dateEnd ?? null)
        @slot('previewDateStart', $previewDateStart ?? null)
        @slot('previewDateEnd', $previewDateEnd ?? null)
        @slot('type', $type ?? null)
    @endcomponent
@endif
