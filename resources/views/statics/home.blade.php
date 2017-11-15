@extends('layouts.app')

@section('content')

<ul class="o-features">
  @foreach ($heroExhibitions as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition, 'feature' => true, 'hero' => $loop->first))
  @endforeach
</ul>

@php
$introBlockActionsPrimary = array();
array_push($introBlockActionsPrimary, array('text' => 'Plan your visit', 'href' => '#'));
$introBlockActionsSecondary = array();
array_push($introBlockActionsSecondary, array('text' => 'Hours and admission', 'href' => '#'));
array_push($introBlockActionsSecondary, array('text' => 'Directions and parking', 'href' => '#'));
@endphp
@include('shared._intro-block', array('intro' => $intro, 'primaryActions' => $introBlockActionsPrimary, 'secondaryActions' => $introBlockActionsSecondary))

@php
$titleBarLinks = array();
array_push($titleBarLinks, array('text' => 'Explore What&rsquo;s on', 'href' => '#'));
@endphp
@include('shared._title-bar', array('title' => 'What&rsquo;s on Today', 'links' => $titleBarLinks))

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

@php
$titleBarLinks = array();
array_push($titleBarLinks, array('text' => 'Explore the Shop', 'href' => '#'));
@endphp
@include('shared._title-bar', array('title' => 'From the Shop', 'links' => $titleBarLinks))

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--5-col@xlarge o-grid-listing--5-col@xxlarge">
  @foreach ($products as $product)
    @include('shared._list-item-product', array('product' => $product))
  @endforeach
</ul>

@endsection
