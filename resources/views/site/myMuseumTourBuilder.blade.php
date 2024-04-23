@extends('layouts.app')

@section('content')
    <div data-behavior="myMuseumTourBuilder" data-hide-from-tours="{{ config('aic.hide_from_tours') }}" data-dsn="{{ config('sentry.dsn') }}">
    </div>
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/myMuseumTourBuilder.js')}}"></script>
@endsection
