@extends('layouts.app')

@section('content')

@include('shared._header-block', array('title' => "Exhibitions and Events"))

@include('shared._intro-block', array('intro' => $intro))

@php
$navTabPrimaryLinksPrimary = array();
array_push($navTabPrimaryLinksPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($navTabPrimaryLinksPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@include('shared._nav-tabs', array('variation' => 'primary', 'linksPrimary' => $navTabPrimaryLinksPrimary))

@php
$navTabSecondaryLinksPrimary = array();
array_push($navTabSecondaryLinksPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($navTabSecondaryLinksPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$navTabSecondaryLinksSecondary = array();
array_push($navTabSecondaryLinksSecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@include('shared._nav-tabs', array('linksPrimary' => $navTabSecondaryLinksPrimary, 'linksSecondary' => $navTabSecondaryLinksSecondary))

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

@endsection
