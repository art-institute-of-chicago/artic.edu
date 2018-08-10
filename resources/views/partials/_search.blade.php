<div class="g-search" data-behavior="globalSearch" data-autocomplete-url="{!! route('search.autocomplete') !!}" aria-modal="true">
    <div class="g-search__scroll">
        <div class="g-search__inner" data-search-inner>
            <form action="/search" class="g-search__form" role="search">
                <input type="search" id="q" name="q" class="g-search__input" placeholder="Search" autocomplete="off" aria-label="Search the site" />
                <button type="submit" class="g-search__submit" data-gtm-event-category="site search" data-gtm-event-action="{{$seo->title}}" data-gtm-event="" aria-label="Search">
                    <svg aria-hidden="true" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
                </button>
                <span class="g-search__loader"></span>
            </form>
            <div class="g-search__suggested">
                <h2 class="g-search__suggested-title" id="h-suggested-terms">Suggested Terms</h2>
                <ul aria-labelledby="h-suggested-terms">
                    @if (isset($searchTerms))
                        @foreach ($searchTerms as $item)
                            <li><a href="{!! $item->direct_url ?? route('search', ['q' => $item->name]) !!}">{{ $item->name }}</a></li>
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
