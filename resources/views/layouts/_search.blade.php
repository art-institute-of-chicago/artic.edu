<div class="g-search" data-behavior="globalSearch" data-autocomplete-url="{!! route('search.autocomplete') !!}">
    <div class="g-search__scroll">
        <div class="g-search__inner" data-search-inner>
            <form action="/search" class="g-search__form">
                <input type="search" id="q" name="q" class="g-search__input" placeholder="Search" autocomplete="off" />
                <button type="submit" class="g-search__submit">
                    <svg aria-label="Search" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
                </button>
                <span class="g-search__loader"></span>
            </form>
            <div class="g-search__suggested">
                <span class="g-search__suggested-title">Suggested Terms</span>
                <ul>
                    @foreach ($searchTerms as $item)
                        <li><a href="{!! route('search', ['q' => $item]) !!}">{{ $item }}</a></li>
                    @endforeach
                </ul>
            </div>
            <button class="g-search__close" data-behavior="globalSearchClose">
                <svg aria-hidden="true" class="icon--close--24"><use xlink:href="#icon--close--24" /></svg>
            </button>
        </div>
    </div>
</div>
