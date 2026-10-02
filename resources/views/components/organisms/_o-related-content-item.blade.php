{{--
    A single Related Content item. Shared by the main list and the overflow
    (accordion) panel so the two lists cannot drift.

    Variables: $relatedItem, $variation (resolved variation key), $imageSettings.
--}}
@if ($variation === 'list-rows')
<li class="o-related-content__item o-related-content__item--row">
    <span class="o-related-content__item-year f-module-title-2">{{ $relatedItem['year'] ?? '' }}</span>

    <div class="o-related-content__item-body">
        @component('components.atoms._title')
            @slot('font', 'f-list-3')
            @slot('title', $relatedItem['title'] ?? '')
        @endcomponent

        @if (!empty($relatedItem['description']))
            <div class="o-related-content__item-description f-secondary">{!! $relatedItem['description'] !!}</div>
        @endif

        <a class="o-related-content__item-link f-link" href="{{ $relatedItem['href'] }}">Learn More &rsaquo;</a>
    </div>
</li>
@else
<li class="o-related-content__item">
    <a class="o-related-content__item-link" href="{{ $relatedItem['href'] }}">
        <span class="o-related-content__item-img m-listing__img{{ !empty($relatedItem['is_video']) ? ' o-related-content__item-img--video' : '' }}">
            @if (!empty($relatedItem['image']))
                @component('components.atoms._img')
                    @slot('image', $relatedItem['image'])
                    @slot('settings', $imageSettings)
                @endcomponent

                @if (!empty($relatedItem['is_video']))
                    <svg class="icon--play--48" aria-hidden="true">
                        <use xlink:href="#icon--play--48"></use>
                    </svg>
                @endif
            @else
                <span class="default-img"></span>
            @endif
        </span>

        <span class="o-related-content__item-eyebrow f-tag">{{ $variation === 'grid-year' ? ($relatedItem['year'] ?? '') : ($relatedItem['eyebrow'] ?? '') }}</span>

        @component('components.atoms._title')
            @slot('font', 'f-list-3')
            @slot('title', $relatedItem['title'] ?? '')
        @endcomponent
    </a>
</li>
@endif
