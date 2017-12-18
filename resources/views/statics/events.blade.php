@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $title }}
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', array(array('text' => 'Exhibitions', 'href' => '#', 'active' => false), array('text' => 'Events', 'href' => '#', 'active' => true)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('text' => 'Today', 'href' => '#', 'active' => true), array('text' => 'Tomorrow', 'href' => '#'), array('text' => 'This weekend', 'href' => '#')))
    @slot('primaryHtml')
        <li class="m-links-bar__item">
            @component('components.atoms._date-select-trigger')
                Pick a date
            @endcomponent
        </li>
    @endslot
    @slot('secondaryVariation', 'm-links-bar__items-secondary--row')
    @slot('secondaryHtml')
        <li class="m-links-bar__item">
            @component('components.atoms._dropdown')
              @slot('prompt', 'All event types')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => 'All event types'),
                array('href' => '#', 'label' => 'Classes and workshops'),
                array('href' => '#', 'label' => 'Live Arts'),
                array('href' => '#', 'label' => 'Screenings'),
                array('href' => '#', 'label' => 'Special Events'),
                array('href' => '#', 'label' => 'Talks'),
                array('href' => '#', 'label' => 'Tours'),
              ))
            @endcomponent
        </li>
        <li class="m-links-bar__item">
            @component('components.atoms._dropdown')
              @slot('prompt', 'All audiences')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => 'All audiences'),
                array('href' => '#', 'label' => 'Classes and workshops'),
                array('href' => '#', 'label' => 'Live Arts'),
                array('href' => '#', 'label' => 'Screenings'),
                array('href' => '#', 'label' => 'Special Events'),
                array('href' => '#', 'label' => 'Talks'),
                array('href' => '#', 'label' => 'Tours'),
              ))
            @endcomponent
        </li>
    @endslot
@endcomponent

@component('components.organisms._o-row-listing')
    @foreach ($eventsByDay as $date)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', array(array('text' => 'See upcoming events', 'href' => '#', 'variation' => 'btn--secondary')))
@endcomponent


@endsection
