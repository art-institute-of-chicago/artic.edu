@extends('layouts.app')

@section('content')

<article class="o-article">

  <header class="o-article__header">
    <h1 class="f-display-2">Display 2</h1>
    <h2 class="f-display-1">Display 1</h2>
    <h3 class="f-headline">Headline</h3>
  </header>

  <div class="o-article__body">
    <p class="f-deck">Deck sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur</p>
    <p class="f-body-editorial">Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur.</p>
    <h4 class="f-module-title-2">Module title 2</h4>
    <p class="f-body-editorial">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>

    <p class="o-article__caption-test f-caption"><strong>Caption bold?</strong><br> Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
  </div>

  <div class="o-article__asides">
    <p>
      <svg class="icon--share--24"><use xlink:href="#icon--share--24" /></svg>
      <svg class="icon--print--24"><use xlink:href="#icon--print--24" /></svg>
    </p>
    <p class="f-buttons">f-buttons</p>
    <p class="f-list-2">List 2 tempus id imperdiet</p>
    <p class="f-secondary">f-secondary</p>
  </div>

</article>


<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@medium o-grid-listing--2-col@large o-grid-listing--2-col@xlarge">
  @foreach ($exhibitions1 as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--3-col@large o-grid-listing--3-col@xlarge">
  @foreach ($exhibitions2 as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge">
  @foreach ($exhibitions3 as $exhibition)
    @include('shared._list-item-exhibition', array('exhibition' => $exhibition))
  @endforeach
</ul>

<div class="m-title-bar">
  <h2 class="m-title-bar__title f-module-title-1">From the Shop</h2>
  <ul class="m-title-bar__links">
    <li><a href="#">Explore the Shop<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
  </ul>
</div>

<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--5-col@xlarge">
  @foreach ($products as $product)
    @include('shared._list-item-product', array('product' => $product))
  @endforeach
</ul>

@endsection
