<div class="o-collection-search" data-behavior="collectionSearch">
    <form>
        <label for="search">Search</label>
        <input name="search" placeholder="Search by keyword, artist or reference">
        <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
    </form>
    <p class="f-tag-2">Quick Search</p>
    <ul class="m-quick-search-links">
    @foreach ($links as $link)
        <li>
            <a href="{{ $link['href'] }}" class="f-tag-2">
                {{ $link['label'] }}
            </a>
        </li>
    @endforeach
    </ul>
    <p class="o-collection-search__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>
