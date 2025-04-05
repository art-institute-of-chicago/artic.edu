<{{ $tag ?? 'li' }}
 class="m-listing m-listing--publication m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}"
 data-filter-values="{{
    str_replace('_', '-', $item->type) . 
    (count($item->categories) > 0 ? ',' : '') .
    $item->categories->pluck('name')->map(function($name) {
        return Str::lower(Str::slug($name));
    })->implode(',')
 }}"
 data-filter-date="{{
    date('d-m-Y', strtotime($item->publish_start_date))
 }}"
  data-filter-title="{{
    Str::lower(Str::slug($item->title))
 }}"
>
    <a href="{{ $href ?? '' }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img">
            @if ($image)
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
            @component('components.atoms._title')
                @slot('font', (isset($variation) && $variation == 'm-listing--work') ? 'f-headline' : 'f-list-3')
                @slot('title', $title)
                @slot('title_display', $title_display)
                @slot('itemprop', 'name')
            @endcomponent
            <br>
            @if ($list_description)
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
            @elseif ($author_display)
                <span class="m-listing__meta-bottom">
                    <span class="f-secondary">{{ $author_display }}</span>
                </span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
