@extends('layouts.app')

@section('content')

@component('components.organisms._o-features')
    @foreach ($heroExhibitions as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
            @slot('variation', ($loop->first) ? 'm-listing--hero' : 'm-listing--feature')
            @slot('titleFont', ($loop->first) ? 'f-list-5' : 'f-list-3')
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-intro-block')
    @slot('links', array(array('label' => 'Plan your visit', 'href' => '#', 'variation' => 'btn')))
    {{ $intro }}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('label' => 'Hours and admission fees', 'href' => '#', 'variation' => 'arrow-link', 'icon' => 'icon--arrow'), array('label' => 'Directions and parking', 'href' => '#', 'variation' => 'arrow-link', 'icon' => 'icon--arrow')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse all current exhibitions', 'href' => '#')))
    Exhibitions and Events
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @foreach ($exhibitions as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('titleFont', 'f-list-4')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('behavior','dragScroll')
    @foreach ($events as $item)
        @component('components.molecules._m-listing----event')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Browse all current exhibitions', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

@component('components.molecules._m-cta-banner----become-a-member')
@endcomponent


@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Explore the collection', 'href' => '#')))
    From the Collection
@endcomponent

@component('components.organisms._o-pinboard')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @slot('maintainOrder','false')
    @foreach ($theCollection as $item)
        @component('components.molecules._m-listing----'.$item->type)
            @slot('variation', 'o-pinboard__item')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the collection', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent



@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Explore the Shop', 'href' => '#')))
    From the Shop
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','4')
    @slot('cols_large','5')
    @slot('cols_xlarge','5')
    @slot('behavior','dragScroll')
    @foreach ($products as $item)
        @component('components.molecules._m-listing----product')
            @slot('simple', true)
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the Shop', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

@endsection
