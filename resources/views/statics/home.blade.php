@extends('layouts.app')

@section('content')

@component('components.organisms._o-features')
    @foreach ($heroExhibitions as $exhibition)
        @component('components.molecules._m-listing----exhibition')
            @slot('exhibition', $exhibition)
            @slot('variation', ($loop->first) ? 'm-listing--hero' : 'm-listing--feature')
            @slot('titleFont', ($loop->first) ? 'f-list-5' : 'f-list-3')
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-intro-block')
    {{ $intro }}
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Plan your visit', 'href' => '#'));
$linksBarSecondary = array();
array_push($linksBarSecondary, array('text' => 'Hours and admission', 'href' => '#', 'icon' => 'icon--arrow', 'variation' => 'arrow-link'));
array_push($linksBarSecondary, array('text' => 'Directions and parking', 'href' => '#', 'icon' => 'icon--arrow', 'variation' => 'arrow-link'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'buttons')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Explore What&rsquo;s on', 'href' => '#')))
    What&rsquo;s on Today
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @slot('cols_xxlarge','2')
    @foreach ($featuredExhibitions as $exhibition)
        @component('components.molecules._m-listing----exhibition')
            @slot('exhibition', $exhibition)
        @endcomponent
    @endforeach
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('cols_xxlarge','4')
    @foreach ($exhibitions as $exhibition)
        @component('components.molecules._m-listing----exhibition')
            @slot('exhibition', $exhibition)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Explore the Shop', 'href' => '#')))
    From the Shop
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','5')
    @slot('cols_xxlarge','5')
    @foreach ($products as $product)
        @component('components.molecules._m-listing----product')
            @slot('product', $product)
        @endcomponent
    @endforeach
@endcomponent

@endsection
