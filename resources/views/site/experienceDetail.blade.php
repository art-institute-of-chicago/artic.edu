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

    @if (count($item->categories) > 0)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            @slot('id', 'h-topics')
            Topics
        @endcomponent
        <ul class="m-inline-list" aria-labelledby="h-topics">
        @foreach ($item->categories as $category)
            <li class="m-inline-list__item">
                @if (!empty($category['id']))
                    <a class="tag f-tag" href="{{ route('articles', ['category' => $category['id']]) }}">{{ $category['name'] }}</a>
                @else
                    <span class="tag f-tag">{{ $category['name'] }}</span>
                @endif
            </li>
        @endforeach
        </ul>
    @endif

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
