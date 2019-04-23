<ul class="m-search-actions">
    <li>
        <button class="f-secondary" data-behavior="showCollectionFilters" aria-label="Toggle filter display">
            <svg class="icon--filter--24"><use xlink:href="#icon--filter--24" /></svg>
            <span class="m-search-actions__label-show">Show</span><span class="m-search-actions__label-hide">Hide</span> Filters
        </button>
    </li>
    <li>
        <a href="{{ $onViewLink }}" data-ajax-scroll-target="collection" class="checkbox f-secondary{{ $onViewActive ? ' s-checked' : '' }}" data-gtm-event="on view" data-gtm-event-action="collection-landing" data-gtm-event-category="collection-filter" data-gtm-filter="on-view">
            On view
        </a>
    </li>
    <li class="u-hide@xsmall">
        <span class="f-secondary">
            @if (isset($total))
                @if ($hasAnyFilter ?? null)
                    {{ $total }} {{ Str::plural('result', $total) }}
                @else
                    All results
                @endif
            @else
                108,789 results
            @endif
        </span>
    </li>
</ul>
