@php
 $itemCategories = isset($item) && isset($item->categories) ? $item->categories->pluck('name') : collect([]);
 $filterValues = '';

 if (isset($item) && isset($item->type)) {
     $filterValues .= str_replace('_', '-', $item->type);
 }

 if ($itemCategories->count() > 0) {
     if (!empty($filterValues)) {
         $filterValues .= ',';
     }
     $filterValues .= $itemCategories->map(function($name) {
         return Str::lower(Str::slug($name));
     })->implode(',');
 }
@endphp

<{{ $tag ?? 'li' }}
  class="m-listing m-listing--publication m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}"
  data-filter-values="{{ $filterValues }}"
  data-filter-date="{{ isset($item) && isset($item->publish_start_date) ? date('d-m-Y', strtotime($item->publish_start_date)) : '' }}"
  data-filter-title="{{ isset($item) && isset($item->title) ? htmlspecialchars($item->title) : '' }}"
>
    <a href="{{ $href ?? '' }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img">
            @if (isset($image) && $image)
                @component('components.atoms._img')
                    @slot('image', $image)
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
            @if ((isset($landingPageType) && $landingPageType === 'publications') && $item->type === 'digital_publication')
                <span class="digital__overlay">Digital</span>
            @endif
            <span class="m-listing__img__overlay">
                <svg class="icon--slideshow--24">
                    <use xlink:href="#icon--slideshow--24"></use>
                </svg>
            </span>
        </span>
        <span class="m-listing__meta">
            @if (isset($label))
                @component('components.atoms._type')
                    {!! $label !!}
                @endcomponent
                <br>
            @endif
            @if (isset($landingPageType) && $landingPageType === 'publications')
                @component('components.atoms._type')
                    {!! date('Y', strtotime($item->publication_date ?? $item->publish_start_date)) !!}
                @endcomponent
                <br>
            @endif
            @if ((isset($title) && $title) || isset($title_display) && $title_display)
                @component('components.atoms._title')
                    @slot('font', (isset($variation) && $variation == 'm-listing--work') ? 'f-headline' : 'f-list-3')
                    @slot('title', $title)
                    @slot('title_display', $title_display)
                    @slot('itemprop', 'name')
                @endcomponent
            @endif
            <br>
            @if (isset($list_description) && $list_description)
                @component('components.atoms._short-description')
                    @slot('font', 'f-body')
                    {!! $list_description !!}
                @endcomponent
            @endif
            <br>
            @if (isset($variation) && $variation == 'm-listing--work')
                <span class="m-listing__meta-bottom">
                    <button class="btn btn--secondary f-buttons">View gallery</button>
                </span>
            @elseif (isset($author_display) && $author_display )
                <span class="m-listing__meta-bottom">
                    <span class="f-secondary">{{ $author_display }}</span>
                </span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
