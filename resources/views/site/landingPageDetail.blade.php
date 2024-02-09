@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div class="o-landingpage__body o-blocks {{Str::kebab($landingPageType)}} {{ $landingPageType === 'my-museum-tours' ? 'o-landingpage__body--aic-ct' : '' }}" id="{{ $landingPageType === 'my-museum-tours' ? 'aic-ct-landingpage' : '' }}">

        {!! $item->renderBlocks(false, [], []) !!}

    </div>

    @include('site.landingPage._footer----'.$landingPageType)

@endsection
