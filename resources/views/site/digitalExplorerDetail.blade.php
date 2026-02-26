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
        @include('partials._head-js')
    @endif

    <script src="{{ FrontendHelpers::revAsset('scripts/digitalExplorer.js') }}"></script>
@endsection