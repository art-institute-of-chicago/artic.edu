<div class="o-collection-search" data-behavior="collectionSearch">
    @component('components.molecules._m-collection-search')
        @slot('placeholder','Search...')
    @endcomponent

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
    <p class="o-collection-search__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>
