@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $page->title }}
@endcomponent

@component('components.molecules._m-intro-block')
    {{ $page->exhibition_intro }}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', array(array('label' => 'Exhibitions', 'href' => route('exhibitions'), 'active' => true), array('label' => 'Events', 'href' => route('events'), 'active' => false)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(
        array('label' => 'Current', 'href' => '#', 'active' => true),
        array('label' => 'Upcoming', 'href' => '#'),
        array('label' => 'Archive', 'href' => '#', 'liVariation' => 'm-links-bar__item--push')
    ))
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @foreach ($page->apiModels('exhibitionsExhibitions', 'Exhibition') as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
            @slot('titleFont', 'f-list-4')
        @endcomponent
    @endforeach
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($collection as $item)
        @if ($loop->index < 6)
            @component('components.molecules._m-listing----exhibition')
               @slot('item', $item)
            @endcomponent
        @endif
    @endforeach
@endcomponent

@component('components.molecules._m-aside-newsletter')
    @slot('variation', 'm-aside-newsletter--wide')
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($collection as $item)
        @if ($loop->index > 5)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
            @endcomponent
        @endif
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', array(array('label' => 'Upcoming Exhibits', 'href' => '#', 'variation' => 'btn--secondary')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => route('events'))))
    Today&rsquo;s Events
@endcomponent

@component('components.organisms._o-row-listing')
    @foreach ($eventsByDay as $date => $events)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
            @slot('events', $events)
        @endcomponent
    @endforeach
@endcomponent


@endsection
