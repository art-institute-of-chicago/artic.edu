<!DOCTYPE html>
<html dir="ltr" lang="en-US" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="format-detection" content="telephone=no">

  <title>AIC</title>

  <!-- Main Favicon -->
  <link rel="shortcut icon" href="{{revAsset('favicon.ico')}}">
  <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
  <link rel="apple-touch-icon" href="{{revAsset('favicon-152.png')}}"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
  <link rel="apple-touch-icon" type="image/png" href="{{revAsset('favicon-120.png')}}" sizes="120x120"> <!-- iPhone retina touch icon -->
  <link rel="apple-touch-icon" type="image/png" href="{{revAsset('favicon-76.png')}}" sizes="76x76"> <!-- iPad home screen icons -->

  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->

  @include('layouts._head-js')
  <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/612324/7579192/css/fonts.css" />
  <link href="{{revAsset('styles/app.css')}}" rel="stylesheet" />
</head>

<body>
<div id="a17">

  @include('layouts._header')

  <main id="content">
    @yield('content')
  </main>

  @include('layouts._footer')
  @include('layouts._calendar')

  @if ( !app()->environment('production'))
    <span class="design-grid-toggle design-grid-toggle--baseline" onClick="this.nextElementSibling.classList.toggle('js-hide');">Toggle baseline grid</span>
    <span class="design-grid design-grid--baseline js-hide"></span>
    <span class="design-grid-toggle design-grid-toggle--columns" data-env="Development" onClick="this.nextElementSibling.classList.toggle('js-hide');">Toggle columns grid</span>
    <span class="design-grid design-grid--columns js-hide"></span>
  @endif

</div>

@include('layouts._scripts')
</body>
</html>
