@extends('layouts.app')

@section('content')

<section class="o-search-results">

@component('components.molecules._m-header-block')
  Search Results
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist, or reference')
    @slot('value', request('q'))
    @slot('name', 'search')
    @slot('behaviors','autocomplete reportSearchToGoogleTagManager')
    @slot('dataAttributes','data-autocomplete-url="'. route('collection.autocomplete') . '"')
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

@if (empty($featuredResults) && empty($artists) && empty($pages) && empty($artworks) && empty($exhibitions) && empty($events) && empty($articles) && empty($researchAndResources))
    @component('components.molecules._m-no-results')
    @endcomponent
@endif

@if (isset($featuredResults) && !$featuredResults->isEmpty())
    @component('components.molecules._m-featured-results')

        @if ($featuredResults->count() == 1)
            @slot('title', 'Featured Result')
            @component('components.molecules._m-listing----'.strtolower(class_basename($featuredResults->first())))
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
                    @component('components.molecules._m-listing----'.strtolower(class_basename($featuredResult)))
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

@if (isset($artists) && $artists->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $artists->getMetadata('pagination')->total.' artists', 'href' => route('search.artists', request()->input()))))
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
        @foreach ($artists as $item)
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

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $artists->appends(request()->input())->links() !!}
    @endif
@endif

{{-- @if (!empty($pages))
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
@endif --}}

@if (isset($artworks) && $artworks->total() > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $artworks->total() .' artworks', 'href' => route('search.artworks', request()->input()))))
        @endunless
        Artworks
    @endcomponent
    @if (isset($allResultsView) and $allResultsView)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.molecules._m-search-actions----collection')
            @slot('onViewLink', route('collection', (request()->filled('is_on_view') ? [] : request()->input() + ['is_on_view' => true])))
            @slot('onViewActive', request()->filled('is_on_view'))

            @slot('total', $artworks->total())
        @endcomponent
        <div class="o-collection-listing__colset">
            <div class="o-collection-listing__col-left">
                @component('components.organisms._o-collection-filters')
                    @slot('activeFilters', $activeFilters)
                    @slot('clearAllLink', route('search.artworks'))
                    @slot('filterCategories', $filterCategories)
                @endcomponent
            </div>
            <div class="o-collection-listing__col-right">
                @component('components.molecules._m-active-filters')
                    @slot('links', $activeFilters)
                    @slot('clearAllLink', route('search.artworks'))
                @endcomponent
                @component('components.organisms._o-pinboard')
                    @slot('id', 'artworksList')
                    @slot('cols_xsmall','2')
                    @slot('cols_small','2')
                    @slot('cols_medium','3')
                    @slot('cols_large','4')
                    @slot('cols_xlarge','4')
                    @slot('maintainOrder','false')
                    @slot('optionLayout','o-pinboard--2-col@xsmall o-pinboard--2-col@small o-pinboard--2-col@medium o-pinboard--3-col@large o-pinboard--3-col@xlarge')
                    @foreach ($artworks as $item)
                        @component('components.molecules._m-listing----artwork')
                            @slot('variation', 'o-pinboard__item')
                            @slot('item', $item)
                            @slot('imageSettings', array(
                                'fit' => null,
                                'ratio' => null,
                                'srcset' => array(200,400,600),
                                'sizes' => aic_gridListingImageSizes(array(
                                      'xsmall' => '2',
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
        </div>

        @component('components.molecules._m-search-triggers----collection')
            @slot('filtersCount',isset($activeFilters) ? count($activeFilters) : 0)
            @slot('showSearch',false)
        @endcomponent
    @else
        @component('components.organisms._o-pinboard')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('maintainOrder','false')
            @foreach ($artworks as $item)
                @component('components.molecules._m-listing----artwork')
                    @slot('variation', 'o-pinboard__item')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => null,
                        'ratio' => null,
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
    @endif

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $artworks->appends(request()->input())->links() !!}
    @endif

@endif

@if (isset($exhibitions))
    @component('components.molecules._m-title-bar')
        @unless (isset($allResultsView) and $allResultsView)
            @slot('links', array(array('label' => 'See all '. $exhibitions->getMetadata('pagination')->total .' exhibitions', 'href' => route('search.exhibitions', request()->input()))))
        @endif
        Exhibitions
    @endcomponent
    @if (isset($allResultsView) and $allResultsView)
        @component('components.molecules._m-links-bar')
            @slot('secondaryHtml')
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Date: ' . (request('time') ? (request('time') == 'upcoming' ? 'Upcoming' : 'Past') : 'All'))
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-link')
                      @slot('font', null)
                      @slot('options', array(
                        array('href' => route('search.exhibitions', ['q' => request('q')]), 'label' => 'All', 'active' => !request()->has('time')),
                        array('href' => route('search.exhibitions', ['q' => request('q'), 'time' => 'upcoming']), 'label' => 'Upcoming', 'active' => request('time') == 'upcoming'),
                        array('href' => route('search.exhibitions', ['q' => request('q'), 'time' => 'past']), 'label' => 'Past', 'active' => request('time') == 'past'),
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

    @if ($exhibitions->getMetadata('pagination')->total > 0)
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
            @foreach ($exhibitions as $item)
                @if(class_basename($item) == 'Exhibition')
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

        @if (isset($allResultsView) && $allResultsView)
            {{-- Pagination --}}
            {!! $exhibitions->appends(request()->input())->links() !!}
        @endif
    @else
        @component('components.molecules._m-no-results')
        @endcomponent
    @endif
@endif

@if (isset($articles) && $articles->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all writings', 'href' => route('articles_publications'))))
        Writings
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($articles as $item)
            @component('components.molecules._m-listing----article')
                @slot('imgVariation','')
                @if ($item->type === 'selection')
                    @slot('singleImage',true)
                @endif
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($publications) && $publications->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all publications', 'href' => route('articles_publications'))))
        Publications
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($publications as $item)
            @component('components.molecules._m-listing----generic')
                @slot('imgVariation','')
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($events) && $events->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => route('events'))))
        Events
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($events as $item)
            @component('components.molecules._m-listing----event')
                @slot('imgVariation','')
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($pages) && $pages->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        Pages
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($pages as $item)
            @component('components.molecules._m-listing----generic')
                @slot('imgVariation','')
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif


@if (isset($researchGuides) && $researchGuides->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all research guides', 'href' => route('collection.resources.research-guides'))))
        Research Guides
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($researchGuides as $item)
            @component('components.molecules._m-listing----generic')
                @slot('imgVariation','')
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($pressReleases) && $pressReleases->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all press releases', 'href' => route('about.press'))))
        Press Releases
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')

        @foreach ($pressReleases as $item)
            @component('components.molecules._m-listing----generic')
                @slot('imgVariation','')
                @slot('item', $item)
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (!empty($researchAndResources))
    @component('components.molecules._m-title-bar')
        @if (isset($researchAndResources['totalResults']) and isset($researchAndResources['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$researchAndResources['totalResults'].' resources', 'href' => $researchAndResources['allResultsHref'])))
        @endif
        Resources
    @endcomponent
    @if (isset($researchAndResources['allResultsView']) and $researchAndResources['allResultsView'])
        @component('components.molecules._m-links-bar')
            @slot('secondaryHtml')
                <li class="m-links-bar__item m-links-bar__item--primary">
                    @component('components.atoms._dropdown')
                      @slot('prompt', 'Show: All')
                      @slot('ariaTitle', 'Filter by')
                      @slot('variation','dropdown--filter f-link')
                      @slot('font', null)
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
