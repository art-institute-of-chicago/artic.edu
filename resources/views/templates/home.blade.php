@extends('layouts.app')

@section('content')

<ul class="o-features">
  <li class="m-listing m-listing--feature o-features__hero-100vw">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <video src="/test/hero-video.mp4" poster="/test/hero-poster.jpg" autoplay loop muted></video>
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Now open</em>
          <span class="m-listing__date f-secondary">September 19, 2015 - January 3, 2016</span>
        </span> <br>
        <strong class="m-listing__title f-display-1">Making Place: The Architecture of David Adjaye</strong>
      </span>
    </a>
  </li>
  <li class="m-listing m-listing--feature">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="/test/feature-1.jpg">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Special Exhibition</em>
        </span> <br>
        <strong class="m-listing__title f-module-title-1">Moholy- Nagy: Future Present</strong> <br>
      </span>
    </a>
  </li>
  <li class="m-listing m-listing--feature">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="/test/feature-2.jpg">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Special Exhibition</em>
        </span> <br>
        <strong class="m-listing__title f-module-title-1">Rubens and his legacy</strong> <br>
      </span>
    </a>
  </li>
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
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Exhibition</em>
        </span> <br>
        <strong class="m-listing__title f-list-3">Cauleen Smith: Human_3.0 Reading Listz</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Oct 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Special Exhibition</em>
          <span class="m-listing__closing-soon f-tag">Closing Soon</span>
        </span> <br>
        <strong class="m-listing__title f-list-3">Cauleen Smith: Human_3.0 Reading Listz</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Oct 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
</ul>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Special Exhibition</em>
        </span> <br>
        <strong class="m-listing__title f-list-3">Cauleen Smith: Human_3.0 Reading Listz</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Oct 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Ongoing</em>
        </span> <br>
        <strong class="m-listing__title f-list-3">Along the Lines: Selected drawings by Saul Steinberg</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Oct 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Ongoing</em>
        </span> <br>
        <strong class="m-listing__title f-list-3">Charles White Murals</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Through Nov 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/400x225">
      </span>
      <span class="m-listing__meta">
        <span class="m-listing__meta-top">
          <em class="m-listing__type f-tag">Ongoing</em>
        </span> <br>
        <strong class="m-listing__title f-list-3">Moholy-Nagy&mdash;Future Present</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__date f-secondary">Through Nov 29, 2017</span>
        </span>
      </span>
    </a>
  </li>
</ul>

<div class="m-title-bar">
  <h2 class="m-title-bar__title f-module-title-1">AIC Shop</h2>
  <ul class="m-title-bar__links">
    <li><a href="#">Explore the Shop<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
  </ul>
</div>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--5-col@xlarge o-grid-listing--5-col@xxlarge">
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/300x300">
      </span>
      <span class="m-listing__meta">
        <strong class="m-listing__title f-list-2">Resin Elephant</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__price f-secondary">$19.99</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/300x300">
      </span>
      <span class="m-listing__meta">
        <strong class="m-listing__title f-list-2">Autumn Glass Leaves</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__price f-secondary">$68</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/300x300">
      </span>
      <span class="m-listing__meta">
        <strong class="m-listing__title f-list-2">Modern Cuff Bracelet</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__price f-secondary"><strike>$80</strike> <span class="m-listing__sale-price">$59.99</span></span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/300x300">
      </span>
      <span class="m-listing__meta">
        <strong class="m-listing__title f-list-2">Tapestry Duffle</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__price f-secondary">$150</span>
        </span>
      </span>
    </a>
  </li>
  <li class="m-listing">
    <a href="#" class="m-listing__link">
      <span class="m-listing__img">
        <img src="http://placehold.dev.area17.com/image/300x300">
      </span>
      <span class="m-listing__meta">
        <strong class="m-listing__title f-list-2">Glass Pumpkin</strong> <br>
        <span class="m-listing__meta-bottom">
          <span class="m-listing__price f-secondary">$79</span>
        </span>
      </span>
    </a>
  </li>
</ul>

@endsection
