<link href="{{FrontendHelpers::revAsset('styles/mirador-kiosk.css')}}" rel="stylesheet" />

@extends('layouts.kiosk')

@section('content')

    @component('components.molecules._m-viewer-mirador')
        @slot('type', 'mirador-kiosk')
        @slot('manifest', $item->getMiradorManifest())
        @slot('defaultView', $item->default_view)
    @endcomponent

@endsection
