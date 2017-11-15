@extends('layouts.app')

@section('content')

@include('shared._intro-block', array('intro' => $intro))

@php
$navTabLinks = array();
array_push($navTabLinks, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($navTabLinks, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@include('shared._nav-tabs', array('links' => $navTabLinks))

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@medium o-grid-listing--2-col@large o-grid-listing--2-col@xlarge o-grid-listing--2-col@xxlarge">
  @foreach ($featuredExhibitions as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @foreach ($exhibitions as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

@endsection
