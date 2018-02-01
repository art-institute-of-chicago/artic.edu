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
    @slot('value', 'Picasso')
    @slot('name', 'search')
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('overflow', true)
    @slot('linksPrimary', array(
      array('label' => 'All (1,312)', 'href' => '#', 'active' => true),
      array('label' => 'Artists (124)', 'href' => '#'),
      array('label' => 'Pages (6)', 'href' => '#'),
      array('label' => 'Artworks (1,242)', 'href' => '#'),
      array('label' => 'Exhibitions &amp; Events (6)', 'href' => '#'),
      array('label' => 'Articles &amp; Publications (3)', 'href' => '#'),
      array('label' => 'Research &amp; Resources (11)', 'href' => '#'),
    ))
@endcomponent

@component('components.atoms._hr')
@endcomponent

@if (isset($artists))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all 124 artists', 'href' => '#')))
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
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($pages))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all 6 other', 'href' => '#')))
        Pages
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-row-listing')
        @foreach ($pages as $item)
            @component('components.molecules._m-listing----generic-row')
                @slot('variation', 'm-listing--row')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($artworks))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all 1,242 artworks', 'href' => '#')))
        Artworks
    @endcomponent
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','true')
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($eventsAndExhibitions))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all 6 events and exhibitions', 'href' => '#')))
        Artworks
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','2')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($eventsAndExhibitions as $item)
            @component('components.molecules._m-listing----'.$item->listingType.'')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($articlesAndPublications))
    @component('components.molecules._m-title-bar')
        Articles &amp; Publications
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','2')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($articlesAndPublications as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('imgVariation','')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($researchAndResources))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all 11 research', 'href' => '#')))
        Research and Resources
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-row-listing')
        @foreach ($researchAndResources as $item)
            @component('components.molecules._m-listing----generic-row')
                @slot('variation', 'm-listing--row')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

</section>

@endsection
