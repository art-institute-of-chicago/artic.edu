@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div id="{{ $landingPageType === 'pre-made' ? 'aic-ct-landingpage' : '' }}" class="o-landingpage__body {{ $landingPageType === 'pre-made' ? 'o-landingpage__body--aic-ct' : '' }} o-blocks">

        {!! $item->renderBlocks(false, [], []) !!}

    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
