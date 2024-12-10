@extends('layouts.app')

@section('content')
    <div data-behavior="myMuseumTourBuilder" data-hide-objects-from-tours="[{{ config('aic.hide_objects_from_tours') }}]" data-hide-galleries-from-tours="[{{ config('aic.hide_galleries_from_tours') }}]" data-dsn="{{ config('sentry.dsn') }}">
    </div>
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/myMuseumTourBuilder.js')}}"></script>
@endsection
