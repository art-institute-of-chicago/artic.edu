<div class="o-collection-search" data-behavior="collectionSearch">
    @component('components.molecules._m-search-bar')
        @slot('placeholder','Search...')
        @slot('name', 'collection-search')
        @slot('action','/statics/collection')
    @endcomponent
    <div class="o-collection-search__scroll-area">
        <p class="o-collection-search__title f-tag-2">Quick Search</p>
        <ul class="o-collection-search__quick-search-links">
        @foreach ($links as $link)
            <li>
                <a href="{{ $link['href'] }}" class="tag tag--quinary f-tag">
                    {{ $link['label'] }}
                </a>
            </li>
        @endforeach
        </ul>
    </div>
    <p class="o-collection-search__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>
