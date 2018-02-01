@extends('layouts.app')

@section('content')

<section class="o-search-results">

@component('components.molecules._m-header-block')
    {{ $title }}
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
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

</section>

@endsection
