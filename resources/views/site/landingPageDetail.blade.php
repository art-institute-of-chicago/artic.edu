@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div id="{{ $landingPageType === 'pre-made' ? 'aic-ct-landingpage' : '' }}"
         @class([
            'o-landingpage__body',
            'o-blocks',
            'o-landingpage__body--aic-ct' => $landingPageType === 'pre-made',
    ])>
        {!! $item->renderBlocks(false, [], []) !!}
    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
