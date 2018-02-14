@extends('layouts.app')

@section('content')

<section class="o-search-results">

@component('components.molecules._m-header-block')
    {{ $title }}
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist or reference')
    @slot('value', $searchTerm)
    @slot('name', 'search')
    @slot('behaviors','autocomplete')
    @slot('dataAttributes','data-autocomplete-url="/search/autocomplete/"')
    @slot('action','/statics/search_results')
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('overflow', true)
    @slot('linksPrimary', $searchResultsTypeLinks)
@endcomponent

@component('components.atoms._hr')
    @slot('variation','hr--flush-top')
@endcomponent

@if (isset($featuredResults))
    @component('components.molecules._m-featured-results')
        @if (sizeof($featuredResults) === 1)
            @slot('title', 'Featured Result')
            @component('components.molecules._m-listing----'.$featuredResults[0]['type'])
                @slot('tag', 'p')
                @slot('variation', 'm-listing--row m-listing--tertiary')
                @slot('imgVariation', 'm-listing__img--square')
                @slot('item', $featuredResults[0]['item'])
            @endcomponent
        @else
            @slot('title', 'Featured Results')
            @component('components.organisms._o-row-listing')
                @foreach ($featuredResults as $featuredResult)
                    @component('components.molecules._m-listing----'.$featuredResult['type'])
                        @slot('variation', 'm-listing--row m-listing--tertiary')
                        @slot('imgVariation', 'm-listing__img--square')
                        @slot('item', $featuredResult['item'])
                    @endcomponent
                @endforeach
            @endcomponent
        @endif
    @endcomponent
@endif

@if (isset($artists))
    @component('components.molecules._m-title-bar')
        @if (isset($artists['totalResults']) and isset($artists['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$artists['totalResults'].' artists', 'href' => $artists['allResultsHref'])))
        @endif
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
        @foreach ($artists['results'] as $item)
            @component('components.molecules._m-listing----artist')
                @slot('variation', 'm-listing--inline m-listing--inline-narrow-image')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
    @if(isset($artists['pagination']) and $artists['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($pages))
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
              @endcomponent
          @endforeach
        @endcomponent
    @else
        @component('components.organisms._o-row-listing')
            @foreach ($pages['results'] as $item)
                @component('components.molecules._m-listing----generic-row')
                    @slot('variation', 'm-listing--row')
                    @slot('item', $item)
                @endcomponent
            @endforeach
        @endcomponent
    @endif
    @if(isset($pages['pagination']) and $pages['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($artworks))
    @component('components.molecules._m-title-bar')
        @if (isset($artworks['totalResults']) and isset($artworks['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$artworks['totalResults'].' artworks', 'href' => $artworks['allResultsHref'])))
        @endif
        Artworks
    @endcomponent
    @if (isset($artworks['allResultsView']) and $artworks['allResultsView'])
        @component('components.atoms._hr')
        @endcomponent
        @component('components.molecules._m-search-actions----collection')
        @endcomponent
        @component('components.molecules._m-active-filters')
            @slot('links', $artworks['activeFilters'])
            @slot('clearAllLink', '/statics/collection')
        @endcomponent
        @component('components.organisms._o-collection-filters')
            @slot('activeFilters', $artworks['activeFilters'])
            @slot('clearAllLink', '/statics/search_results_artworks')
            @slot('filterCategories', $artworks['filterCategories'])
        @endcomponent
    @endif
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','true')
        @foreach ($artworks['results'] as $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
    @if(isset($artworks['pagination']) and $artworks['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($eventsAndExhibitions))
    @component('components.molecules._m-title-bar')
        @if (isset($eventsAndExhibitions['totalResults']) and isset($eventsAndExhibitions['allResultsHref']))
            @slot('links', array(array('label' => 'See all '.$eventsAndExhibitions['totalResults'].' events and exhibitions', 'href' => $eventsAndExhibitions['allResultsHref'])))
        @endif
        Events and Exhibitions
    @endcomponent
    @if (isset($eventsAndExhibitions['allResultsView']) and $eventsAndExhibitions['allResultsView'])
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
        @if (isset($eventsAndExhibitions['allResultsView']) and $eventsAndExhibitions['allResultsView'])
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
        @foreach ($eventsAndExhibitions['results'] as $item)
            @component('components.molecules._m-listing----'.$item->listingType.'')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
    @if(isset($eventsAndExhibitions['pagination']) and $eventsAndExhibitions['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($articlesAndPublications))
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
            @endcomponent
        @endforeach
    @endcomponent
    @if(isset($articlesAndPublications['pagination']) and $articlesAndPublications['pagination'])
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif
@endif

@if (isset($researchAndResources))
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
              @endcomponent
          @endforeach
        @endcomponent
    @else
        @component('components.organisms._o-row-listing')
            @foreach ($researchAndResources['results'] as $item)
                @component('components.molecules._m-listing----generic-row')
                    @slot('variation', 'm-listing--row')
                    @slot('item', $item)
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
