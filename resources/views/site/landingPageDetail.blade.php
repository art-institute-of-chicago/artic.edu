@extends('layouts.app')

@section('content')

    @include('site.landingPage._header----'.$landingPageType)

    <div class="o-landingpage__body o-blocks {{StringHelpers::pageBlades($landingPageType)}}">

        {!! $item->renderBlocks(false, [], []) !!}

    </div>
    
    @include('site.landingPage._footer----'.$landingPageType)

@endsection
