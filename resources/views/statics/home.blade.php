@extends('layouts.app')

@section('content')

<ul class="o-features">
  @foreach ($heroExhibitions as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition, 'feature' => true, 'hero' => $loop->first))
  @endforeach
</ul>

<div class="m-info-block">
  <p class="f-deck">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor. Quisque tristique laoreet lectus sit amet tempus. Aliquam vel eleifend nisi.</p>
  <div class="m-info-block__footer">
    <ul class="m-info-block__footer-actions-primary">
      <li><a href="#" class="btn">Plan your visit</a></li>
    </ul>
    <ul class="m-info-block__footer-actions-secondary">
      <li><a href="#">Hours and admission<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
      <li><a href="#">Directions and parking<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
    </ul>
  </div>
</div>

<div class="m-title-bar">
  <h2 class="m-title-bar__title f-module-title-1">What’s on Today</h2>
  <ul class="m-title-bar__links">
    <li><a href="#">Explore What’s on<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
  </ul>
</div>

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

<div class="m-title-bar">
  <h2 class="m-title-bar__title f-module-title-1">From the Shop</h2>
  <ul class="m-title-bar__links">
    <li><a href="#">Explore the Shop<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
  </ul>
</div>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--5-col@xlarge o-grid-listing--5-col@xxlarge">
  @foreach ($products as $product)
    @include('shared._list-item-product', array('product' => $product))
  @endforeach
</ul>

@endsection
