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
    @slot('name', 'q')
    @slot('behaviors','reportSearchToGoogleTagManager')
    @slot('action', route('search'))
    @slot('limit', isset($allResultsView) && $allResultsView ? true : false)
@endcomponent

@if (!empty($searchResultsTypeLinks))
    @component('components.molecules._m-links-bar')
        @slot('overflow', true)
        @slot('isPrimaryPageNav', true)
        @slot('linksPrimary', $searchResultsTypeLinks)
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-top')
    @endcomponent
@endif

@if (empty($featuredResults) && empty($artists) && empty($educatorResources) && empty($pressReleases) && empty($pages) && empty($press) && empty($publications) && empty($artworks) && empty($exhibitions) && empty($events) && empty($articles) && empty($interactiveFeatures) && empty($highlights))
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
                            'sizes' => ImageHelpers::aic_imageSizes(array(
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
            @slot('links', array(array('label' => 'See all '. $artists->getMetadata('pagination')->total.' '. Str::plural('artist', $artists->getMetadata('pagination')->total) .'/' . Str::plural('culture', $artists->getMetadata('pagination')->total), 'href' => route('search.artists', request()->input()))))
        @endunless
        Artists/Cultures
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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


@if (isset($pages) && $pages->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless($allResultsView)
            @slot('links', array(array('label' => 'See all '. $pages->getMetadata('pagination')->total. ' '. Str::plural('page', $pages->getMetadata('pagination')->total), 'href' => route('search.pages', ['q' => request('q')]))))
        @endif
        Pages
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols  o-grid-listing--gridlines-top')
            @slot('cols_xsmall','1')
            @slot('cols_small','2')
            @slot('cols_medium','2')
            @slot('cols_large','3')
            @slot('cols_xlarge','3')
            @foreach ($pages as $item)
                @component('components.molecules._m-listing----page-search')
                    @slot('imgVariation','')
                    @slot('item', $item)
                    @slot('image', $item->imageFront('listing', 'default'))
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

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','3')
            @slot('cols_xlarge','3')

            @foreach ($pages as $item)
                @component('components.molecules._m-listing----page-search')
                    @slot('item', $item)
                    @slot('image', $item->imageFront('listing', 'default'))
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $pages->appends(request()->except('page'))->render() !!}
    @endif
@endif

@if (isset($artworks) && $artworks->total() > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $artworks->total() .' ' .Str::plural('artwork', $artworks->total()), 'href' => route('search.artworks', request()->input()))))
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
                @component('components.organisms._o-pinboard----artwork')
                    @slot('artworks', $artworks ?? null)
                @endcomponent
            </div>
        </div>

        @component('components.molecules._m-search-triggers----collection')
            @slot('filtersCount',isset($activeFilters) ? count($activeFilters) : 0)
            @slot('showSearch',false)
        @endcomponent
    @else
        @component('components.organisms._o-pinboard----artwork')
            @slot('artworks', $artworks ?? null)
        @endcomponent
    @endif

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $artworks->appends(request()->input())->links() !!}
    @endif

@endif

@if (isset($highlights) && $highlights->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $highlights->getMetadata('pagination')->total. ' '. Str::plural('highlight', $articles->getMetadata('pagination')->total), 'href' => route('search.highlights', ['q' => request('q')]))))
        @endunless
        Highlights
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($highlights as $item)
              @component('components.molecules._m-listing----article')
                  @slot('module', 'highlights')
                  @slot('imgVariation','')
                  @slot('item', $item)
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

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($highlights as $item)
                @component('components.molecules._m-listing----article')
                    @slot('module', 'highlights')
                    @slot('imgVariation','')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $highlights->appends(request()->except('page'))->render() !!}
    @endif
@endif

@if (isset($exhibitions))
    @component('components.molecules._m-title-bar')
        @unless (isset($allResultsView) and $allResultsView)
            @slot('links', array(array('label' => 'See all '. $exhibitions->getMetadata('pagination')->total .' ' .Str::plural('exhibition', $exhibitions->getMetadata('pagination')->total), 'href' => route('search.exhibitions', request()->input()))))
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
                    @slot('imgVariation','m-listing__img--no-bg')
                    @slot('item', $item)
                    @if (isset($allResultsView) and $allResultsView)
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
                    @else
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '16:9',
                            'srcset' => array(200,400,600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
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


@if (isset($events) && $events->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless($allResultsView)
            @slot('links', array(array('label' => 'See all '. $events->getMetadata('pagination')->total. ' '. Str::plural('event', $events->getMetadata('pagination')->total), 'href' => route('search.events', ['q' => request('q')]))))
        @endif
        Events
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($events as $item)
              @component('components.molecules._m-listing----event')
                  @slot('item', $item)
                  @slot('hideImage', true)
              @endcomponent
          @endforeach
        @endcomponent

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($events as $item)
                @component('components.molecules._m-listing----event')
                      @slot('item', $item)
                      @slot('hideImage', true)
                @endcomponent
            @endforeach
        @endcomponent

    @endif

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $events->appends(request()->except('page'))->render() !!}
    @endif
@endif


@if (isset($articles) && $articles->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $articles->getMetadata('pagination')->total. ' '. Str::plural('writing', $articles->getMetadata('pagination')->total), 'href' => route('search.articles', ['q' => request('q')]))))
        @endunless
        Articles
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($articles as $item)
              @component('components.molecules._m-listing----article')
                  @slot('imgVariation','')
                  @slot('item', $item)
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

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($articles as $item)
                @component('components.molecules._m-listing----article')
                    @slot('imgVariation','')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $articles->appends(request()->except('page'))->render() !!}
    @endif
@endif

@if (isset($interactiveFeatures) && $interactiveFeatures->total() > 0)

    @component('components.molecules._m-title-bar')
        @unless($allResultsView)
            @slot('links', array(array('label' => 'See all '. $interactiveFeatures->total(). ' '. Str::plural('interactive feature', $interactiveFeatures->total()), 'href' => route('search.interactive-features', ['q' => request('q')]))))
        @endunless
        Interactive Features
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($interactiveFeatures as $item)
            @component('components.molecules._m-listing----experience')
                @slot('item', $item)
                @slot('image', $item->imageFront())
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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

    @else

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($interactiveFeatures as $item)
                @component('components.molecules._m-listing----experience')
                    @slot('item', $item)
                    @slot('image', $item->imageFront('hero'))
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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
@endif

@if (isset($publications) && $publications->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless ($allResultsView)
            @slot('links', array(array('label' => 'See all '. $publications->getMetadata('pagination')->total. ' '. Str::plural('publication', $publications->getMetadata('pagination')->total), 'href' => route('search.publications', ['q' => request('q')]))))
        @endunless
        Publications
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($publications as $item)
              @component('components.molecules._m-listing----generic')
                  @slot('imgVariation','')
                  @slot('item', $item)
                  @slot('image', $item->imageFront('listing', 'default'))
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

    @else

        @component('components.atoms._hr')
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
                    @slot('image', $item->imageFront('listing', 'default'))
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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

    @if (isset($allResultsView) && $allResultsView)
        {{-- Pagination --}}
        {!! $publications->appends(request()->except('page'))->render() !!}
    @endif
@endif

@if (isset($educatorResources) && $educatorResources->getMetadata('pagination')->total > 0)
    @component('components.molecules._m-title-bar')
        @unless($allResultsView)
            @slot('links', array(array('label' => 'See all '. $educatorResources->getMetadata('pagination')->total. ' '. Str::plural('resource', $educatorResources->getMetadata('pagination')->total), 'href' => route('search.educator-resources', ['q' => request('q')]))))
        @endunless

        Resources
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($educatorResources as $item)
              @component('components.molecules._m-listing----generic')
                  @slot('item', $item)
                  @slot('hideImage', true)
              @endcomponent
          @endforeach
        @endcomponent

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($educatorResources as $item)
                @component('components.molecules._m-listing----generic')
                    @slot('item', $item)
                    @slot('hideImage', true)
                @endcomponent
            @endforeach
        @endcomponent

    @endif
@endif

@if (isset($pressReleases) && $pressReleases->getMetadata('pagination')->total > 0)

    @component('components.molecules._m-title-bar')
        @unless($allResultsView)
            @slot('links', array(array('label' => 'See all '. $pressReleases->getMetadata('pagination')->total. ' '. Str::plural('press release', $pressReleases->getMetadata('pagination')->total), 'href' => route('search.press-releases', ['q' => request('q')]))))
        @endunless
        Press Releases
    @endcomponent

    @if (isset($allResultsView) && $allResultsView)

        @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
          @slot('cols_small','2')
          @slot('cols_medium','3')
          @slot('cols_large','4')
          @slot('cols_xlarge','4')
          @foreach ($pressReleases as $item)
              @component('components.molecules._m-listing----generic')
                  @slot('item', $item)
                  @slot('hideImage', true)
              @endcomponent
          @endforeach
        @endcomponent

    @else

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--gridlines-cols')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')

            @foreach ($pressReleases as $item)
                @component('components.molecules._m-listing----generic')
                    @slot('item', $item)
                    @slot('hideImage', true)
                @endcomponent
            @endforeach
        @endcomponent

    @endif
@endif

</section>

@endsection
