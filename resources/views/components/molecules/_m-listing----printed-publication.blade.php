<{{ $tag ?? 'li' }}
 class="m-listing m-listing--publication m-listing--w-meta-bottom{{ isset($variation) ? ' '.$variation : '' }}"
 data-filter-values="{{
    isset($item->type) ? str_replace('_', '-', $item->type) : '' .
    (isset($item->categories) && count($item->categories) > 0 ? ',' : '') .
    (isset($item->categories) ? $item->categories->pluck('name')->map(function($name) {
        return Str::lower(Str::slug($name));
    })->implode(',') : '')
}}"
 data-filter-date="{{
    isset($item->publish_start_date) ? date('d-m-Y', strtotime($item->publish_start_date)) : ''
}}"
 data-filter-title="{{
    isset($item->title) ? htmlspecialchars($item->title) : ''
}}"

<a href="{{ $href ?? '' }}" class="m-listing__link"{!! isset($gtmAttributes) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img">
        @if ((isset($image) && $image) || $item->imageFront('listing'))
            @component('components.atoms._img')
                @slot('image', $image ?? $item->imageFront('listing'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            <span class="default-img"></span>
        @endif
        @if ((isset($landingPageType) && $landingPageType === 'publications') && isset($item->type) && $item->type === 'digital_publication')
            <span class="digital__overlay">Digital</span>
        @endif
        <span class="m-listing__img__overlay">
            <svg class="icon--slideshow--24">
                <use xlink:href="#icon--slideshow--24"></use>
            </svg>
        </span>
    </span>
    <span class="m-listing__meta">
        @if ((isset($landingPageType) && $landingPageType === 'publications') && isset($label))
            @component('components.atoms._type')
                {!! $label !!}
            @endcomponent
            <br>
        @else
            @component('components.atoms._type')
                {!! $item->subtype !!}
            @endcomponent
        @endif
        @if (isset($landingPageType) && $landingPageType === 'publications')
            @component('components.atoms._type')
                {!! isset($item->publication_date) ? date('Y', strtotime($item->publication_date)) : (isset($item->publish_start_date) ? date('Y', strtotime($item->publish_start_date)) : '') !!}
            @endcomponent
            <br>
        @endif
        @if ((isset($title) && $title) ||  isset($item->title))
            @component('components.atoms._title')
                @slot('font', (isset($variation) && $variation == 'm-listing--work') ? 'f-headline' : 'f-list-3')
                @slot('title', $title ?? $item->title)
                @slot('title_display', $title_display ?? $item->title_display)
                @slot('itemprop', 'name')
            @endcomponent
        @endif
        <br>
        @if ((isset($list_description) && $list_description) || (isset($item) && isset($item->list_description)))
            @component('components.atoms._short-description')
                @slot('font', 'f-body')
                {!! $list_description ?? $item->list_description !!}
            @endcomponent
        @endif
        <br>
        @if (isset($variation) && $variation == 'm-listing--work')
            <span class="m-listing__meta-bottom">
                <button class="btn btn--secondary f-buttons">View gallery</button>
            </span>
        @elseif (isset($author_display) && $author_display)
            <span class="m-listing__meta-bottom">
                <span class="f-secondary">{{ $author_display }}</span>
            </span>
        @endif
    </span>
</a>
</{{ $tag ?? 'li' }}>
