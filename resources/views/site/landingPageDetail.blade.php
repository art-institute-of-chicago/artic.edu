use Illuminate\Support\Str;

@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div class="o-landingpage__body o-blocks {{Str::kebab($landingPageType)}} {{ $landingPageType === 'my-museum-tours' ? 'o-landingpage__body--aic-ct' : '' }}" id="{{ $landingPageType === 'my-museum-tours' ? 'aic-ct-landingpage' : '' }}">

        {!! $item->renderBlocks(false, data: ['landingPageType' => $landingPageType]) !!}

    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
