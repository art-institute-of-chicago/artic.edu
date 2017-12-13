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
    @slot('links', array(array('text' => 'Plan your visit', 'href' => '#', 'variation' => 'btn')))
    {{ $intro }}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('text' => 'Hours and admission fees', 'href' => '#', 'variation' => 'arrow-link', 'icon' => 'icon--arrow'), array('text' => 'Directions and parking', 'href' => '#', 'variation' => 'arrow-link', 'icon' => 'icon--arrow')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Browse all current exhibitions', 'href' => '#')))
    Exhibitions and Events
@endcomponent
<span class="hr"></span>
@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @slot('cols_xxlarge','2')
    @foreach ($exhibitions as $exhibition)
        @component('components.molecules._m-listing----exhibition')
            @slot('titleFont', 'f-list-4')
            @slot('exhibition', $exhibition)
        @endcomponent
    @endforeach
@endcomponent
<span class="hr"></span>
@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('cols_xxlarge','4')
    @slot('behavior','dragScroll')
    @foreach ($events as $event)
        @component('components.molecules._m-listing----event')
            @slot('event', $event)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('text' => 'Browse all current exhibitions', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Explore the Shop', 'href' => '#')))
    From the Shop
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','4')
    @slot('cols_large','5')
    @slot('cols_xlarge','5')
    @slot('cols_xxlarge','5')
    @slot('behavior','dragScroll')
    @foreach ($products as $product)
        @component('components.molecules._m-listing----product')
            @slot('simple', true)
            @slot('product', $product)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('text' => 'Explore the Shop', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

@endsection
