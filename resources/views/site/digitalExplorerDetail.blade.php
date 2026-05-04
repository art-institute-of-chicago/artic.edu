@php
$isKioskMode = isset($isKiosk) && $isKiosk;
@endphp

@extends($isKioskMode ? 'layouts.kiosk' : 'layouts.app')
<html
    dir="ltr"
    lang="{{ app()->getLocale() }}"
    @class([
        'no-js',
        's-unsticky-header' => isset($unstickyHeader) && $unstickyHeader,
        's-contrast-header' => isset($contrastHeader) && $contrastHeader,
        's-borderless-header' => isset($borderlessHeader) && $borderlessHeader && empty($hour),
        's-filled-logo' => isset($filledLogo) and $filledLogo,
        's-roadblock-defined' => !empty($roadblocks) && $roadblocks->count() > 0,
        's-serif-loaded' => isset($_COOKIE["A17_fonts_cookie_serif"]),
        's-sans-serif-loaded' => isset($_COOKIE["A17_fonts_cookie_sans-serif"]),
        's-dark-mode' => isset($darkMode) && $darkMode,
        's-env-' . app()->environment(),
    ])
  >
@if($isKioskMode)
    @push('head')
        @include('partials._head-js')
        <link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet" async />
        <link rel="preconnect" href="https://artic-web.imgix.net" />
        <link rel="preconnect" href="https://cdnjs.cloudflare.com" />
        <link rel="preload" href="https://www.artic.edu/fonts/sabon/3545D5_0_0.woff2" as="font" type="font/woff2" crossorigin="anonymous" />
        <link rel="preload" href="https://www.artic.edu/fonts/sabon/3545D5_1_0.woff2" as="font" type="font/woff2" crossorigin="anonymous" />
        <link rel="preload" href="https://www.artic.edu/fonts/sabon/3545D5_2_0.woff2" as="font" type="font/woff2" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://vjs.zencdn.net/7.1.0/video-js.css" />
        <style>
            {{FrontendHelpers::embedAsset('styles/setup.css')}}
        </style>

          <!-- Main Favicon -->
        <link rel="shortcut icon" type="image/png" href="{{FrontendHelpers::revAsset('images/aic-favicon.svg')}}">
        <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
        <link rel="apple-touch-icon-precomposed" href="{{FrontendHelpers::revAsset('images/aic-favicon.svg')}}"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
        <link rel="apple-touch-icon-precomposed" type="image/png" href="{{FrontendHelpers::revAsset('images/aic-favicon.svg')}}" sizes="120x120"> <!-- iPhone retina touch icon -->
        <link rel="apple-touch-icon-precomposed" type="image/png" href="{{FrontendHelpers::revAsset('images/aic-favicon.svg')}}" sizes="76x76"> <!-- iPad home screen icons -->

        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <![endif]-->

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="svg-sprite-src" content="{{ FrontendHelpers::revAsset('icons/icons.svg') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @endpush
@endif

@section('content')
    <div class="o-digital-explorer {{ $isKioskMode ? 'kioskMode' : '' }}"
         data-behavior="digitalExplorer">
    </div>

    <script type="application/json" data-digitalExplorer-contentBundle>
        @json($explorerData)
    </script>

    @include('partials._mask')
    @include('partials._calendar')
    @include('partials._fullscreenImage')
    @include('partials._share-menu')
    @include('partials._nav-mobile')
    @include('partials._search')
    @include('partials._modal')
    @include('partials._ajax-loader')
    @include('partials._scripts')

    <script src="{{ FrontendHelpers::revAsset('scripts/digitalExplorer.js') }}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/layeredImageViewer.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
