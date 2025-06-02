@extends('layouts.app')

@section('content')

<section class="o-educator-resources">

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
                @slot('ariaTitle', 'Filter by content')
                @slot('variation','m-filters m-filters__dropdown-down-arrow')
                @slot('options', $contentOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="content"')
            @endcomponent
        </div>

        <div class="dropdown__container">
            <p class="f-secondary">Audience</p>
            @component('components.atoms._dropdown')
                @slot('ariaTitle', 'Filter by audience')
                @slot('variation','dropdown--filter__sort m-filters m-filters__dropdown-down-arrow')
                @slot('options', $audienceOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="audience"')
            @endcomponent
        </div>

        <div class="dropdown__container">
            <p class="f-secondary">Topic</p>
            @component('components.atoms._dropdown')
                @slot('ariaTitle', 'Filter by topic')
                @slot('variation','dropdown--filter__sort f-link m-filters m-filters__dropdown-down-arrow')
                @slot('options', $topicOptions)
                @slot('behavior', 'dynamicFilterDropdown')
                @slot('attribute', 'data-filter-behavior="filter" data-filter-label="topic"')
            @endcomponent
        </div>

            @component('components.atoms._checkbox')
                @slot('attribute', 'data-filter-behavior="checkbox"')
                @slot('id', null)
                @slot('label', 'Español')
            @endcomponent

    </div>

    <div data-behavior='dynamicFilter'>
        @component('components.organisms._o-grid-listing')
            @slot('behavior', 'data-filter-target')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','3')
            @slot('cols_xlarge','3')
            @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')

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

        @endcomponent
    </div>


</section>

@endsection