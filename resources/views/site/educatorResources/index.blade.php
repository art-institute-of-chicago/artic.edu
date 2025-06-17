@extends('layouts.app')

@section('content')

<section class="o-educator-resources" data-behavior='dynamicFilter' data-filter-persist='true'>

    @component('components.molecules._m-article-header')
        @slot('headerType', 'generic')
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent

    @component('components.molecules._m-header-block')
      Educator Resources
    @endcomponent


    <div class="m-links-bar__item m-links-bar__item--primary" data-filter-buttons>

        <div class="dropdown__container">
            <p class="f-secondary">Content</p>
            @component('components.atoms._dropdown')
                @slot('prompt', 'All')
                @slot('ariaTitle', 'Filter by content')
                @slot('variation','m-filters m-filters__dropdown-down-arrow')
                @slot('options', $contentOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="content" data-filter-persist')
            @endcomponent
        </div>

        <div class="dropdown__container">
            <p class="f-secondary">Audience</p>
            @component('components.atoms._dropdown')
                @slot('prompt', 'All')
                @slot('ariaTitle', 'Filter by audience')
                @slot('variation','dropdown--filter__sort m-filters m-filters__dropdown-down-arrow')
                @slot('options', $audienceOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="audience" data-filter-persist')
            @endcomponent
        </div>

        <div class="dropdown__container">
            <p class="f-secondary">Topic</p>
            @component('components.atoms._dropdown')
                @slot('prompt', 'All')
                @slot('ariaTitle', 'Filter by topic')
                @slot('variation','dropdown--filter__sort f-link m-filters m-filters__dropdown-down-arrow')
                @slot('options', $topicOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="topic" data-filter-persist')
            @endcomponent
        </div>

        <a class="checkbox f-secondary" data-behavior="dynamicFilterCheckbox" data-filter-behavior="filter" data-filter-label="locale" data-filter-value="es" data-filter-persist>
            Espanol
        </a>

    </div>

    <div data-filter-target>
        <div class="o-educator-resources__listing-grid">
          @foreach ($items as $item)
              @component('components.molecules._m-listing----educator-resource')
                  @slot('item', $item)
                  @slot('hideDescription', false)
                  @slot('imageSettings', array(
                      'fit' => 'crop',
                      'ratio' => '16:9',
                      'srcset' => array(200,400,600),
                      'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                            'xsmall' => '1',
                            'small' => '2',
                            'medium' => '3',
                            'large' => '4',
                            'xlarge' => '4',
                      )),
                  ))
              @endcomponent
          @endforeach
        </div>
    </div>


</section>

@endsection