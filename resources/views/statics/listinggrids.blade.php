@extends('layouts.app')

@section('content')

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing, no cols</p>
<ul class="o-grid-listing">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-top">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-rows">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing, 2 cols at small, 3 cols at medium, 4 cols large+ (most examples follow this)</p>
<ul class="o-grid-listing o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--keyline-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-right</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-cols</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<div style="margin-top: 60px;"></div>
<p class="f-secondary">5 Column Shop</p>
<ul class="o-grid-listing o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--4-col@medium o-grid-listing--5-col@large o-grid-listing--5-col@xlarge o-grid-listing--5-col@xxlarge">
  <?php for ($i = 0; $i < 5; $i++): ?>
    <li class="m-listing">
      <a href="#" class="m-listing__link">
        <span class="m-listing__img" style="height: 200px !important;">
          <img src="http://placehold.dev.area17.com/image/400x100" style="height: 200px !important;">
        </span>
      </a>
    </li>
  <?php endfor; ?>
</ul>

@endsection
