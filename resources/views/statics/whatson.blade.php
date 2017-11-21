@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    Exhibitions and Events
@endcomponent

@component('components.molecules._m-intro-block')
    {{ $intro }}
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'tabs')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Current', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Upcoming', 'href' => '#', 'active' => false));
$linksBarSecondary = array();
array_push($linksBarSecondary, array('text' => 'Archive', 'href' => '#'));
@endphp

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@medium o-grid-listing--2-col@large o-grid-listing--2-col@xlarge o-grid-listing--2-col@xxlarge">
  @foreach ($featuredExhibitions as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--3-col@large o-grid-listing--3-col@xlarge o-grid-listing--3-col@xxlarge">
  @foreach ($exhibitions as $exhibition)
    @if ($loop->index < 6)
      @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
    @endif
  @endforeach
</ul>

@component('components.molecules._m-aside-newsletter')
@endcomponent

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--3-col@large o-grid-listing--3-col@xlarge o-grid-listing--3-col@xxlarge">
  @foreach ($exhibitions as $exhibition)
    @if ($loop->index > 5)
      @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
    @endif
  @endforeach
</ul>

@component('components.molecules._m-links-bar')
    @slot('variation', 'buttons')
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
