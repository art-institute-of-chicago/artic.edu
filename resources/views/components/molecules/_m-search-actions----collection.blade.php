<ul class="m-search-actions">
    <li>
        <button class="f-secondary" data-behavior="showCollectionFilters">
            <svg class="icon--filter--24"><use xlink:href="#icon--filter--24" /></svg>
            Show Filters
        </button>
    </li>
    <li>
        <a href="{{ $onViewLink }}" data-ajax-scroll-target="collection" class="checkbox f-secondary{{ $onViewActive ? ' s-checked' : '' }}">
            On view
        </a>
    </li>
    <li class="u-hide@xsmall">
        <span class="f-secondary">
            @if (isset($total))
                {{ $total }} {{ str_plural('result', $total) }}
            @else
                108,789 results
            @endif
        </span>
    </li>
</ul>
