@extends('layouts.app')

@section('content')

@include('shared._header-block', array('title' => "Exhibitions and Events"))

@include('shared._intro-block', array('intro' => $intro))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@include('shared._links-bar', array('variation' => 'tabs', 'linksPrimary' => $linksBarPrimary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$linksBarSecondary = array();
array_push($linksBarSecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@include('shared._links-bar', array('linksPrimary' => $linksBarPrimary, 'linksSecondary' => $linksBarSecondary))

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

@include('shared._aside-newsletter')

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--3-col@large o-grid-listing--3-col@xlarge o-grid-listing--3-col@xxlarge">
  @foreach ($exhibitions as $exhibition)
    @if ($loop->index > 5)
      @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
    @endif
  @endforeach
</ul>

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Upcoming Exhibits', 'href' => '#', 'variation' => 'btn--secondary'));
@endphp
@include('shared._links-bar', array('variation' => 'buttons', 'linksPrimary' => $linksBarPrimary))

@php
$titleBarLinks = array();
array_push($titleBarLinks, array('text' => 'Browse events', 'href' => '#'));
@endphp
@include('shared._title-bar', array('title' => 'Today&rsquo;s Events', 'links' => $titleBarLinks))

<ul class="o-grid-listing">
@foreach ($eventsByDay as $date)
  <li class="m-date-listing">
    <h3 class="day">
        <span class="day__date f-date-numeral">{{ $date['date']['date'] }}</span>
        <span class="day__month f-tag">{{ $date['date']['month'] }}</span>
        <span class="day__day f-tag">{{ $date['date']['day'] }}</span>
    </h3>
    <ul class="m-date-listing__items">
    @foreach ($date['events'] as $event)
        <li class="m-listing m-listing--row">
          <a href="{{ $event->slug }}" class="m-listing__link">
            <span class="m-listing__img">
              <img src="{{ $event->image['src'] }}">
            </span>
            <span class="m-listing__meta">
              @if ($event->exclusive)<em class="exclusive f-tag">Member Exclusive</em>@endif
              <em class="type f-tag">{{ $event->type }}</em> <br>
              <strong class="title f-list-2">{{ $event->title }}</strong> <br>
              <span class="date f-secondary">{{ $event->timeStart }}-{{ $event->timeEnd }}</span>
            </span>
          </a>
        </li>
    @endforeach
    </ul>
  </li>
@endforeach
</ul>


@endsection
