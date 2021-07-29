@extends('layouts.app')

@section('content')

@php
$typespecs = array("f-display-1", "f-headline", "f-headline-editorial", "f-deck", "f-module-title-2", "f-module-title-1", "f-subheading-1", "f-body", "f-body-emphasis", "f-body-editorial", "f-body-editorial-emphasis", "f-body-editorial-reference", "f-buttons", "f-secondary", "f-tertiary", "f-link", "f-tag-2", "f-tag", "f-caption-title", "f-caption", "f-list-7", "f-list-6", "f-list-5", "f-list-4", "f-list-3", "f-list-2", "f-list-1", "f-quote", "f-main-nav");
@endphp

<ul class="sg-type-spec">
  <li>
    <p class="f-body">f-display-3</p>
    <p class="f-display-3">Lorem</p>
    <p class="f-body">f-display-3</p>
    <p class="f-display-3">Ipsum</p>
  </li>
  <li>
    <p class="f-body">f-display-2</p>
    <p class="f-display-2">Lorem</p>
    <p class="f-body">f-display-2</p>
    <p class="f-display-2">Ipsum</p>
  </li>
  <li>
    <p class="f-body">f-numeral-date</p>
    <p class="f-numeral-date">1234567890</p>
    <p class="f-body">f-numeral-date</p>
    <p class="f-numeral-date">1234567890</p>
  </li>
  <li>
    <p class="f-body">f-dropcap-editorial w f-dropcap-editorial</p>
    <p class="f-body-editorial"><span class="f-dropcap-editorial">L</span>orem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vehicula libero vel quam fringilla dignissim. Praesent finibus sem sed arcu tempor, non tincidunt magna luctus. Maecenas lacinia interdum lacinia. Pellentesque ac felis vehicula, fermentum mauris sed, ornare ex. Mauris cursus, nulla eget fermentum molestie, metus velit sodales turpis, nec tempus felis orci id erat.</p>
  </li>
  @foreach ($typespecs as &$typespec)
  <li>
    <p class="{{ $typespec }}">{{ $typespec }}</p>
    <p class="{{ $typespec }}">The quick brown fox, <br>jumps over the lazy dog</p>
    <p class="f-body">The quick brown fox, <br>jumps over the lazy dog</p>
    <p class="{{ $typespec }}">The quick brown fox, <br>jumps over the lazy dog</p>
    <p class="f-body">The quick brown fox, <br>jumps over the lazy dog</p>
  </li>
  @endforeach
</ul>

@endsection
