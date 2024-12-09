@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div class="o-landingpage__body o-blocks {{Str::kebab($landingPageType)}} {{ $landingPageType === 'my-museum-tour' ? 'o-landingpage__body--aic-ct' : '' }}" id="{{ $landingPageType === 'my-museum-tour' ? 'aic-ct-landingpage' : '' }}">

        {!! $item->renderBlocks(data: ['landingPageType' => $landingPageType]) !!}

    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
