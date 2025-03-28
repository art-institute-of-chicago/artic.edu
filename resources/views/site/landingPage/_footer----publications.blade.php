<div class="o-landingpage__footer publications" data-behavior="dynamicFilter"> {{-- wrapper for container here --}}
    <div class="publications-title-bar">
        <h2 class="title f-module-title-2" id="publications">
            Publications
        </h2>
        <div class="m-links-bar__item m-links-bar__item--primary" data-filter-buttons>
            @component('components.atoms._dropdown')
                @slot('prompt', 'Sort By')
                @slot('ariaTitle', 'Sort By')
                @slot('variation','dropdown--filter f-link')
                @slot('font', null)
                @slot('options', $sortOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="sort"')
            @endcomponent
        </div>
    </div>

    @component('components.molecules._m-search-bar')
        @slot('behaviors', 'dynamicFilterSearch')
        @slot('placeholder', 'Search by keyword, title, author, date, etc.')
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation','m-links-bar--publications')
        @slot('dataAttributes', 'data-filter-buttons') {{-- data-filter-buttons here --}}
        @slot('primaryHtml')
            @foreach ($primaryFilters as $filter)
                <li data-filter-default data-behavior="dynamicFilterButton" data-button-value="{{$filter['value']}}" class="m-links-bar__item m-links-bar__item--primary">
                    <a class="f-link">{{$filter['label']}}</a>
                </li>
            @endforeach
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                    @slot('prompt', 'Subject Category')
                    @slot('ariaTitle', 'Filter by')
                    @slot('variation','dropdown--filter f-link')
                    @slot('font', null)
                    @slot('options', $categories)
                    @slot('behavior', 'dynamicFilterDropdown')
                    @slot('attribute', 'data-filter-behavior="filter"')
                @endcomponent
            </li>
        @endslot
    @endcomponent
    <div data-filter-target> {{-- wrapper for filter here --}}
        @component('components.organisms._o-gridboard')
            @slot('id', 'publicationList')
            @slot('cols_xsmall','2')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @component('site.publications._items')
                @slot('publications', $publications)
            @endcomponent
        @endcomponent
    </div>
    @if ($item->publicationResources)
        <div class="publications-title-bar publication-resources">
            <h2 style="margin-top: 75px" class="title f-module-title-2" id="resources">
                Resources
            </h2>
        </div>
        <div class="publication-resources-container">
            @foreach ($item->publicationResources as $resource)
                <div class="publication-resource">
                    <h3 id={{Str::kebab(Str::lower($resource->resource_target))}}>{{$resource->resource_title}}</h3>
                    <p>{!!$resource->resource_description!!}</p>
                    <a href={{$resource->resource_link_url}}>{{$resource->resource_link_label}}<svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></a>
                </div>
            @endforeach
        </div>
    @endif
</div>
