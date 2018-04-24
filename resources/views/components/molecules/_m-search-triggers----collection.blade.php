<ul class="m-search-triggers">
    <li>
        <button class="f-secondary" data-behavior="showCollectionFilters">
            <svg class="icon--filter--24"><use xlink:href="#icon--filter--24" /></svg>
            Filter <em>(1)</em>
        </button>
    </li>
    @unless (isset($showSearch) and !$showSearch)
    <li>
        <button class="f-secondary" data-behavior="showCollectionSearch">
            <svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
        </button>
    </li>
    @endunless
</ul>
