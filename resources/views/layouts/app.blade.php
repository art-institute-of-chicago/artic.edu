@php
$print = isset($_GET['print']);
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="en-US" class="no-js{{ (isset($contrastHeader) and $contrastHeader) ? ' s-contrast-header' : '' }}{{ (isset($filledLogo) and $filledLogo) ? ' s-filled-logo' : '' }}{{ $print ? ' s-print' : '' }}  {{ !empty($roadblock) ? 's-roadblock-active' : '' }}{{ isset($_COOKIE["A17_fonts_cookie_serif"]) ? ' s-serif-loaded' : '' }}{{ isset($_COOKIE["A17_fonts_cookie_sans-serif"]) ? ' s-sans-serif-loaded' : '' }} s-env-{{ app()->environment() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="format-detection" content="telephone=no">

  <title>AIC</title>

  <!-- Main Favicon -->
  <link rel="shortcut icon" type="image/png" href="{{revAsset('images/favicon-16.png')}}">
  <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
  <link rel="apple-touch-icon-precomposed" href="{{revAsset('images/favicon-152.png')}}"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
  <link rel="apple-touch-icon-precomposed" type="image/png" href="{{revAsset('images/favicon-120.png')}}" sizes="120x120"> <!-- iPhone retina touch icon -->
  <link rel="apple-touch-icon-precomposed" type="image/png" href="{{revAsset('images/favicon-76.png')}}" sizes="76x76"> <!-- iPad home screen icons -->

  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->

  <meta name="csrf-token" content="{{ csrf_token() }}">

  @include('layouts._head-js')
  <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/612324/7579192/css/fonts.css" />
  <style>
  @import url("//hello.myfonts.net/count/3545d5");
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_0_0.eot')}});src: url({{revAsset('fonts/3545D5_0_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_0_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_0_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_0_0.ttf')}}) format('truetype');font-weight:normal;font-weight:400;font-style:normal;}
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_1_0.eot')}});src: url({{revAsset('fonts/3545D5_1_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_1_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_1_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_1_0.ttf')}}) format('truetype');font-weight:normal;font-weight:400;font-style:italic;}
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_2_0.eot')}});src: url({{revAsset('fonts/3545D5_2_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_2_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_2_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_2_0.ttf')}}) format('truetype');font-weight:normal;font-weight:500;font-style:normal;}
  </style>
  <link href="{{revAsset('styles/app.css')}}" rel="stylesheet" />
</head>

<body>
<div id="a17">

  @include('layouts._header')

  <main id="content">
    @yield('content')
  </main>

  @include('layouts._footer')

  @if ( !app()->environment('production'))
    @include('layouts._designgrids')
  @endif
</div>

@include('layouts._mask')
@include('layouts._calendar')
@include('layouts._fullscreenImage')
@include('layouts._share-menu')
@include('layouts._info-button-info')
@include('layouts._nav-mobile')
@include('layouts._search')
@include('layouts._modal')

@if (!empty($roadblock))
    @component('layouts._modal-promo', [ 'modal' => $roadblock])
    @endcomponent
@endif

@include('layouts._scripts')
@if ($print)
    <script>window.print();</script>
@endif
</body>
</html>
