@extends('layouts.app')

@section('content')
    <div data-behavior="myMuseumTourBuilder">
    </div>
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/myMuseumTourBuilder.js')}}"></script>
@endsection
