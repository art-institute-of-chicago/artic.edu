<div class="g-search" data-behavior="search">
    <div class="g-search__scroll">
        <div class="g-search__inner">
            <form action="" class="g-search__form">
                <input type="search" id="q" name="q" class="g-search__input" placeholder="Search" />

                <button type="submit" class="g-search__submit">
                    <svg aria-label="Search" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
                </button>
            </form>

            <div class="g-search__suggested">
                <span class="g-search__suggested-title">Suggested Terms</span>
                <ul>
                    @foreach ($search['suggested'] as $item)
                        <li><a href="#">{{ $item }}</a></li>
                    @endforeach
                </ul>
            </div>

            <a href="#" class="g-search__close" data-search-close>
                <svg aria-hidden="true" class="icon--close--24"><use xlink:href="#icon--close--24" /></svg>
            </a>

            <div data-autocomplete></div>
        </div>
    </div>
</div>
