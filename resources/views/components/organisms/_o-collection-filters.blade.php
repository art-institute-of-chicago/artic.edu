<div class="o-collection-filters" id="collectionFilters">

    <div class="o-collection-filters__scroll-area">

        @if (!empty($activeFilters) and sizeof($activeFilters) > 0)
        <div class="m-active-filters o-collection-filters__active-filters">
            <ul class="m-active-filters__items">
            @foreach ($activeFilters as $link)
                <li class="m-active-filters__item">
                    <a href="{{ $link['href'] }}" class="tag tag--quaternary tag--l f-tag" data-ajax-scroll-target="collection">
                        {{ $link['label'] }}
                        <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
                    </a>
                </li>
            @endforeach
            </ul>
            <p class="m-active-filters__clear">
                <a href="{{ $clearAllLink }}" class="f-link">Clear all</a>
            </p>
        </div>
        @endif

        @if (isset($filterCategories) and sizeof($filterCategories) > 0)
            <div class="o-accordion o-collection-filters__filters" role="tablist" multiselectable="true" data-behavior="accordion">
            @foreach ($filterCategories as $filterCategory)

                @if (isset($filterCategory['collapsible']) and !$filterCategory['collapsible'])
                    <p class="o-accordion__trigger s-inactive f-tag-2">
                        {{ $filterCategory['title'] }}
                    </p>
                    <div class="o-accordion__panel s-inactive">
                        <div class="o-accordion__panel-content m-filters">

                            @if ($filterCategory['type'] === 'dropdown')
                                @component('components.atoms._dropdown')
                                  @slot('prompt', $filterCategory['prompt'] ?? $filterCategory['title'])
                                  @slot('ariaTitle', 'Filter by')
                                  @slot('options', $filterCategory['list'])
                                @endcomponent
                            @endif

                            @if ($filterCategory['type'] === 'date')
                                @component('components.atoms._range-slider----date-filter')
                                @endcomponent
                            @endif

                            @if ($filterCategory['type'] === 'list')
                                @component('components.blocks._collection-filters-list')
                                    @slot('filterCategory', $filterCategory)
                                @endcomponent
                            @endif

                        </div>
                    </div>
                @else
                    <p id="filters_trigger_{{ $loop->iteration }}" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_{{ $loop->iteration }}" aria-expanded="{{ (isset($filterCategory['active']) and $filterCategory['active']) ? 'true' : 'false' }}" role="tab" tabindex="0">
                        {{ $filterCategory['title'] }}
                        <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                    </p>
                    <div id="filters_{{ $loop->iteration }}" class="o-accordion__panel" aria-labelledby="filters_trigger_{{ $loop->iteration }}" aria-hidden="{{ (isset($filterCategory['active']) and $filterCategory['active']) ? 'false' : 'true' }}" role="tabpanel">
                        <div class="o-accordion__panel-content m-filters">

                            @if ($filterCategory['type'] === 'dropdown')
                                @component('components.atoms._dropdown')
                                  @slot('prompt', $filterCategory['prompt'] ?? $filterCategory['title'])
                                  @slot('ariaTitle', 'Filter by')
                                  @slot('options', $filterCategory['list'])
                                @endcomponent
                            @endif

                            @if ($filterCategory['type'] === 'date')
                                @component('components.atoms._range-slider----date-filter')
                                @endcomponent
                            @endif

                            @if ($filterCategory['type'] === 'list')
                                @component('components.blocks._collection-filters-list')
                                    @slot('filterCategory', $filterCategory)
                                @endcomponent
                            @endif

                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        @endif
    </div>

    <p class="o-collection-filters__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionFilters">Close Filters</button>
    </p>
</div>
