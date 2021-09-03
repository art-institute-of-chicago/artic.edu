@extends('layouts.app')
@section('content')
    @php($item = isset($singleSlide) && $singleSlide ? $slide : $experience)
    <section class="o-closer-look" data-behavior="closerLook">
            <script type="application/json" data-closerLook-contentBundle>
                {!! json_encode($item->contentBundle) !!}
            </script>
            <script type="application/json" data-closerLook-assetLibrary>
                {!! json_encode($item->assetLibrary) !!}
            </script>
    </section>

    <section>
        @component('site.shared._relatedItems')
            @slot('title', $furtherReadingTitle ?? null)
            @slot('relatedItems', $furtherReadingItems ?? null)
        @endcomponent
    </section>
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/interactiveFeatures.js')}}"></script>
@endsection
