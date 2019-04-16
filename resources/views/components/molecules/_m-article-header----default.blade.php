<{{ $tag ?? 'header' }} class="m-article-header m-article-header--default{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (!empty($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            @slot('itemprop','name')
            @slot('title', $title)
            @slot('title_display', $title_display ?? null)
        @endcomponent
    @endif

    {{-- Preview dates --}}
    @component('components.organisms._o-preview-dates')
        @slot('previewDateStart', $previewDateStart ?? null)
        @slot('previewDateEnd', $previewDateEnd ?? null)
    @endcomponent

    {{-- Regular dates --}}
    @component('components.organisms._o-public-dates')
        @slot('tag', 'p')
        @slot('formattedDate', $formattedDate ?? null)
        @slot('dateStart', $dateStart ?? null)
        @slot('dateEnd', $dateEnd ?? null)
        @slot('date', $date ?? null)
    @endcomponent

    @if (!empty($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
    @endif
</{{ $tag ?? 'header' }}>
