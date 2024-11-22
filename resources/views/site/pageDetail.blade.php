@extends('layouts.app')

@section('content')

    @if ($item->type === \App\Models\Page::PAGE_TYPE_HOME)
        @include('partials._fixed-header--home')
    @elseif ($item->type === \App\Models\Page::PAGE_TYPE_VISIT)
        @include('partials._fixed-header--visit')
    @elseif ($item->type === \App\Models\Page::PAGE_TYPE_RESEARCH_LANDING)
        @include('partials._fixed-header--research-landing')
    @endif

    <div class="o-page__body o-blocks">

        {!! $item->renderBlocks() !!}

    </div>

    @if ($item->type === \App\Models\Page::PAGE_TYPE_HOME)
        @include('partials._fixed-footer--home')
    @elseif ($item->type === \App\Models\Page::PAGE_TYPE_VISIT)
        @include('partials._fixed-footer--visit')
    @elseif ($item->type === \App\Models\Page::PAGE_TYPE_RESEARCH_LANDING)
        @include('partials._fixed-footer--research-landing')
    @endif

@endsection
