@extends('layouts.kiosk')

@section('content')

    @component('components.molecules._m-viewer-mirador')
        @slot('type', 'miradorKiosk')
        @slot('manifest', $item->getMiradorManifest())
        @slot('defaultView', $item->getMiradorView())
    @endcomponent

@endsection
