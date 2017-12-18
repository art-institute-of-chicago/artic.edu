@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    Exhibitions and Events
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', array(array('text' => 'Exhibitions', 'href' => '#', 'active' => true), array('text' => 'Events', 'href' => '#', 'active' => false)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('text' => 'Current', 'href' => '#', 'active' => true), array('text' => 'Upcoming', 'href' => '#', 'active' => false)))
    @slot('linksSecondary', array(array('text' => 'Archive', 'href' => '#')))
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @slot('cols_xxlarge','2')
    @foreach ($featuredExhibitions as $exhibition)
        @component('components.molecules._m-listing----exhibition')
            @slot('exhibition', $exhibition)
            @slot('titleFont', 'f-list-4')
        @endcomponent
    @endforeach
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @slot('cols_xxlarge','3')
    @foreach ($exhibitions as $exhibition)
        @if ($loop->index < 6)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
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
    @slot('variation', 'o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @slot('cols_xxlarge','3')
    @foreach ($exhibitions as $exhibition)
        @if ($loop->index > 5)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endif
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', array(array('text' => 'Upcoming Exhibits', 'href' => '#', 'variation' => 'btn--secondary')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Browse events', 'href' => '#')))
    Today&rsquo;s Events
@endcomponent

@component('components.organisms._o-row-listing')
    @foreach ($eventsByDay as $date)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
        @endcomponent
    @endforeach
@endcomponent


@endsection
