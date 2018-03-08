@extends('layouts.app')

@section('content')

<section class="o-search-results">

@component('components.molecules._m-header-block')
  Search Results
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist or reference')
    @slot('value', request('q'))
    @slot('name', 'search')
    @slot('behaviors','autocomplete')
    @slot('dataAttributes','data-autocomplete-url="'. route('search.autocomplete') . '"')
    @slot('action', route('search'))
@endcomponent

@if (!empty($searchResultsTypeLinks))
    @component('components.molecules._m-links-bar')
        @slot('overflow', true)
        @slot('linksPrimary', $searchResultsTypeLinks)
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-top')
    @endcomponent
@endif

@if (empty($featuredResults) && empty($artists) && empty($pages) && empty($artworks) && empty($eventsAndExhibitions) && empty($articlesAndPublications) && empty($researchAndResources))
    <div class="o-search-results__no-results">
        @component('components.atoms._hr')
        @endcomponent
        @component('components.atoms._title')
            @slot('tag','h2')
            @slot('font', 'f-list-3')
            Sorry, we couldn't find any results matching your criteria
        @endcomponent
    </div>
@endif

@if (isset($featuredResults) && !$featuredResults->isEmpty())
    @component('components.molecules._m-featured-results')

        @if ($featuredResults->count() == 1)
            @slot('title', 'Featured Result')
            @component('components.molecules._m-listing----'.strtolower($featuredResults->first()->getClassName()))
                @slot('tag', 'p')
                @slot('variation', 'm-listing--row m-listing--tertiary')
                @slot('imgVariation', 'm-listing__img--square')
                @slot('item', $featuredResults->first())
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '1:1',
                    'srcset' => array(150,300,500),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '90vw',
                          'small' => '11vw',
                          'medium' => '11vw',
                          'large' => '8vw',
                          'xlarge' => '130px',
                    )),
                ))
            @endcomponent
        @else
            @slot('title', 'Featured Results')
            @component('components.organisms._o-row-listing')
                @foreach ($featuredResults as $featuredResult)
                    @component('components.molecules._m-listing----'.strtolower($featuredResult->getClassName()))
                        @slot('variation', 'm-listing--row m-listing--tertiary')
                        @slot('imgVariation', 'm-listing__img--square')
                        @slot('item', $featuredResult)
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '1:1',
                            'srcset' => array(150,300,500),
                            'sizes' => aic_imageSizes(array(
                                  'xsmall' => '90vw',
                                  'small' => '11vw',
                                  'medium' => '11vw',
                                  'large' => '8vw',
                                  'xlarge' => '130px',
                            )),
                        ))
                    @endcomponent
                @endforeach
            @endcomponent
        @endif
    @endcomponent
@endunless

@if (isset($artists) && $artists->pagination->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $artists->pagination->total.' artists', 'href' => route('search'))))
        @endunless
        Artists
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($artists->items as $item)
            @component('components.molecules._m-listing----artist')
                @slot('variation', 'm-listing--inline m-listing--inline-narrow-image')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '1:1',
                    'srcset' => array(100,200),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '10',
                          'small' => '8',
                          'medium' => '5',
                          'large' => '4',
                          'xlarge' => '4',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent

    {{-- Pagination --}}
    {!! $artists->items->links() !!}
@endif

@if (!empty($pages))
    @component('components.molecules._m-title-bar')
        @if (isset($pages['totalResults']) and isset($pages['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$pages['totalResults'].' pages', 'href' => $pages['allResultsHref'])))
        @endif
        Pages
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @if (isset($pages['allResultsView']) and $pages['allResultsView'] and sizeof($pages['results']) > 6)
        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($pages['results'] as $item)
              @component('components.molecules._m-listing----generic-row')
                  @slot('imgVariation','')
                  @slot('item', $item)
                  @slot('imageSettings', array(
                      'fit' => 'crop',
                      'ratio' => '16:9',
                      'srcset' => array(200,400,600),
                      'sizes' => aic_gridListingImageSizes(array(
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
    @else
        @component('components.organisms._o-row-listing')
            @foreach ($pages['results'] as $item)
                @component('components.molecules._m-listing----generic-row')
                    @slot('variation', 'm-listing--row')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '13',
                              'medium' => '13',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @endforeach
        @endcomponent
    @endif
    @if(isset($pages['pagination']) and $pages['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($artworks) && $artworks->pagination->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $artworks->pagination->total .' artworks', 'href' => route('search'))))
        @endunless
        Artworks
    @endcomponent
    @if (isset($allResultsView) and $allResultsView)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.molecules._m-search-actions----collection')
        @endcomponent
        @component('components.molecules._m-active-filters')
            @slot('links', $activeFilters)
            @slot('clearAllLink', '/statics/collection')
        @endcomponent
        @component('components.organisms._o-collection-filters')
            @slot('activeFilters', $activeFilters)
            @slot('clearAllLink', '/statics/search_results_artworks')
            @slot('filterCategories', $filterCategories)
        @endcomponent
    @endif
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','true')
        @foreach ($artworks->items as $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600),
                    'sizes' => aic_gridListingImageSizes(array(
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

    {{-- Pagination --}}
    {!! $artworks->items->links() !!}

@endif

@if (isset($eventsAndExhibitions) && $eventsAndExhibitions->pagination->total > 0)
    @component('components.molecules._m-title-bar')
        @unless (isset($allResultsView) and $allResultsView)
            @slot('links', array(array('label' => 'See all '. $eventsAndExhibitions->pagination->total .' events and exhibitions', 'href' => route('exhibitions'))))
        @endif
        Events and Exhibitions
    @endcomponent
    @if (isset($allResultsView) and $allResultsView)
        @component('components.molecules._m-links-bar')
            @slot('secondaryHtml')
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Date: Upcoming')
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-buttons')
                      @slot('font', 'f-buttons')
                      @slot('options', array(
                        array('href' => '#', 'label' => 'Upcoming', 'active' => true),
                        array('href' => '#', 'label' => 'Past'),
                      ))
                    @endcomponent
                </li>
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Show: All')
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-buttons')
                      @slot('font', 'f-buttons')
                      @slot('options', array(
                        array('href' => '#', 'label' => 'All', 'active' => true),
                        array('href' => '#', 'label' => 'Exhibitions'),
                        array('href' => '#', 'label' => 'Events'),
                      ))
                    @endcomponent
                </li>
            @endslot
        @endcomponent
        @component('components.atoms._hr')
            @slot('variation','hr--flush-top')
        @endcomponent
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    @component('components.organisms._o-grid-listing')
        @if (isset($allResultsView) and $allResultsView)
            @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
        @else
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
        @endif
        @foreach ($eventsAndExhibitions->items as $item)
            @if($item->getClassName() == 'Exhibition')
                @component('components.molecules._m-listing----exhibition')
            @else
                @component('components.molecules._m-listing----event')
            @endif
                @slot('item', $item)
                @if (isset($allResultsView) and $allResultsView)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_gridListingImageSizes(array(
                              'xsmall' => '1',
                              'small' => '2',
                              'medium' => '3',
                              'large' => '4',
                              'xlarge' => '4',
                        )),
                    ))
                @else
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '216px',
                              'small' => '216px',
                              'medium' => '18',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endif
            @endcomponent
        @endforeach
    @endcomponent

    {{-- Pagination --}}
    {!! $eventsAndExhibitions->items->links() !!}
@endif

@if (!empty($articlesAndPublications))
    @component('components.molecules._m-title-bar')
        @if (isset($articlesAndPublications['totalResults']) and isset($articlesAndPublications['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$articlesAndPublications['totalResults'].' articles &amp; publications', 'href' => $articlesAndPublications['allResultsHref'])))
        @endif
        Articles &amp; Publications
    @endcomponent
    @if (isset($articlesAndPublications['allResultsView']) and $articlesAndPublications['allResultsView'])
        @component('components.molecules._m-links-bar')
            @slot('secondaryHtml')
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Show: All')
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-buttons')
                      @slot('font', 'f-buttons')
                      @slot('options', array(
                        array('href' => '#', 'label' => 'All', 'active' => true),
                        array('href' => '#', 'label' => 'Articles'),
                        array('href' => '#', 'label' => 'Publications'),
                      ))
                    @endcomponent
                </li>
            @endslot
        @endcomponent
        @component('components.atoms._hr')
            @slot('variation','hr--flush-top')
        @endcomponent
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    @component('components.organisms._o-grid-listing')
        @if (isset($articlesAndPublications['allResultsView']) and $articlesAndPublications['allResultsView'])
            @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
        @else
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
        @endif
        @foreach ($articlesAndPublications['results'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('imgVariation','')
                @slot('item', $item)
                @if (isset($articlesAndPublications['allResultsView']) and $articlesAndPublications['allResultsView'])
                    @slot('imageSettings', array(
                        'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                        'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                        'srcset' => array(200,400,600),
                        'sizes' => aic_gridListingImageSizes(array(
                              'xsmall' => '1',
                              'small' => '2',
                              'medium' => '3',
                              'large' => '4',
                              'xlarge' => '4',
                        )),
                    ))
                @else
                    @slot('imageSettings', array(
                        'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                        'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '216px',
                              'small' => '216px',
                              'medium' => '18',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endif
            @endcomponent
        @endforeach
    @endcomponent
    @if(isset($articlesAndPublications['pagination']) and $articlesAndPublications['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (!empty($researchAndResources))
    @component('components.molecules._m-title-bar')
        @if (isset($researchAndResources['totalResults']) and isset($researchAndResources['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$researchAndResources['totalResults'].' research &amp; resources', 'href' => $researchAndResources['allResultsHref'])))
        @endif
        Research &amp; Resources
    @endcomponent
    @if (isset($researchAndResources['allResultsView']) and $researchAndResources['allResultsView'])
        @component('components.molecules._m-links-bar')
            @slot('secondaryHtml')
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Show: All')
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-buttons')
                      @slot('font', 'f-buttons')
                      @slot('options', array(
                        array('href' => '#', 'label' => 'All', 'active' => true),
                        array('href' => '#', 'label' => 'Research'),
                        array('href' => '#', 'label' => 'Resources'),
                      ))
                    @endcomponent
                </li>
            @endslot
        @endcomponent
        @component('components.atoms._hr')
            @slot('variation','hr--flush-top')
        @endcomponent
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    @if (isset($researchAndResources['allResultsView']) and $researchAndResources['allResultsView'] and sizeof($researchAndResources['results']) > 6)
        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($researchAndResources['results'] as $item)
              @component('components.molecules._m-listing----generic-row')
                  @slot('imgVariation','')
                  @slot('item', $item)
                  @slot('imageSettings', array(
                      'fit' => 'crop',
                      'ratio' => '16:9',
                      'srcset' => array(200,400,600),
                      'sizes' => aic_gridListingImageSizes(array(
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
    @else
        @component('components.organisms._o-row-listing')
            @foreach ($researchAndResources['results'] as $item)
                @component('components.molecules._m-listing----generic-row')
                    @slot('variation', 'm-listing--row')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '13',
                              'medium' => '13',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @endforeach
        @endcomponent
    @endif
    @if(isset($researchAndResources['pagination']) and $researchAndResources['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

</section>

@endsection
