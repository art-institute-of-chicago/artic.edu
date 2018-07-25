<div class="g-search" data-behavior="globalSearch" data-autocomplete-url="{!! route('search.autocomplete') !!}">
    <div class="g-search__scroll">
        <div class="g-search__inner" data-search-inner>
            <form action="/search" class="g-search__form" role="search">
                <input type="search" id="q" name="q" class="g-search__input" placeholder="Search" autocomplete="off" aria-label="Search the site" />
                <button type="submit" class="g-search__submit" aria-label="Search">
                    <svg aria-hidden="true" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
                </button>
                <span class="g-search__loader"></span>
            </form>
            <div class="g-search__suggested">
                <span class="g-search__suggested-title">Suggested Terms</span>
                <ul>
                    @if (isset($searchTerms))
                        @foreach ($searchTerms as $item)
                            <li><a href="{!! route('search', ['q' => $item]) !!}">{{ $item }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <button class="g-search__close" data-behavior="globalSearchClose" aria-label="Close search">
                <svg aria-hidden="true" class="icon--close--24"><use xlink:href="#icon--close--24" /></svg>
            </button>
        </div>
    </div>
</div>
