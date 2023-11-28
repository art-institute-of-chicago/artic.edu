@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div class="o-landingpage__body o-blocks {{StringHelpers::pageBlades($landingPageType)}}" id="{{ $landingPageType === 'pre-made' ? 'aic-ct-landingpage' : '' }}">

        {!! $item->renderBlocks(false, [], []) !!}
    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
