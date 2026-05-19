@php
$isKioskMode = isset($isKiosk) && $isKiosk;
@endphp

@extends($isKioskMode ? 'layouts.kiosk' : 'layouts.app')

@if($isKioskMode)
    @push('head')
        <link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet" async />
        <link rel="preconnect" href="https://artic-web.imgix.net" />
        <link rel="preconnect" href="https://cdnjs.cloudflare.com" />

        <link rel="stylesheet" href="https://vjs.zencdn.net/7.1.0/video-js.css" />
        <style>
            {{FrontendHelpers::embedAsset('styles/setup.css')}}
        </style>
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

    @if($isKioskMode)
        @include('partials._mask')
        @include('partials._calendar')
        @include('partials._fullscreenImage')
        @include('partials._share-menu')
        @include('partials._nav-mobile')
        @include('partials._search')
        @include('partials._modal')
        @include('partials._ajax-loader')
    @endif

    <script src="{{FrontendHelpers::revAsset('scripts/digitalExplorer.js') }}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/layeredImageViewer.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
