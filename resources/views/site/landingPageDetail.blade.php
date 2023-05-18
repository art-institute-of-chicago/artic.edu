@extends('layouts.app')

@section('content')

    @switch($item->type)
        @case(1)
            @php
            $pageType = 'home'
            @endphp

            @break
        @case(4)
            @php
            $pageType = 'visit'
            @endphp

            @break
        @case(8)
            @php
            $pageType = 'research-landing'
            @endphp

            @break
    @endswitch

    @include('site.landingPage._header----'.$pageType)

    <div class="o-landingpage__body o-blocks">

        {!! $item->renderBlocks(false, [], []) !!}

    </div>

    {{-- @if ($item->type === \App\Models\LandingPage::PAGE_TYPE_HOME)
        @include('partials._fixed-footer--home')
    @elseif ($item->type === \App\Models\LandingPage::PAGE_TYPE_VISIT)
        @include('partials._fixed-footer--visit')
    @elseif ($item->type === \App\Models\LandingPage::PAGE_TYPE_RESEARCH_LANDING)
        @include('partials._fixed-footer--research-landing')
    @endif --}}

@endsection
