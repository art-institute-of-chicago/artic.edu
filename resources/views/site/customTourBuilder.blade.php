@extends('layouts.app')

@section('content')
    <div data-behavior="customTourBuilder">
    </div>
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/customTourBuilder.js')}}"></script>
@endsection
