{{-- INTEGRATION DEPRECATION NOTICE: --}}

{{-- This partial has been moved directly to site.collections.index --}}
{{-- It's used only once and for integration purposes works better to have it there --}}

<div class="o-collection-search" data-behavior="collectionSearch">
    @component('components.molecules._m-search-bar')
        @slot('placeholder','Search...')
        @slot('name', 'collection-search')
        @slot('action','/statics/collection')
        @slot('behaviors','ajaxFormSubmit')
        @slot('gtmAttributes', 'data-gtm-event="click" data-gtm-event-category="collection-search"')
    @endcomponent
    <div class="o-collection-search__scroll-area">
        <p class="o-collection-search__title f-tag-2">Quick Search</p>
        <ul class="o-collection-search__quick-search-links">
        @foreach ($links as $link)
            <li>
                <a href="{{ $link['href'] }}" class="tag tag--quinary f-tag" data-gtm-event="quick-search-click" data-gtm-event-category="collection-search" data-gtm-term="{{ getUtf8Slug($link['label']) }}">
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
