@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-sidebar-toggle')
        @slot('title', 'Art Institue Review')
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--journal-article">
        @component('components.molecules._m-article-actions----journal-article')
            @slot('item', $item)
        @endcomponent
    </div>

    @component('components.molecules._m-article-header----journal-article')
        @slot('title', $item->present()->title)
        @slot('title_display', $item->present()->title_display)
        @slot('img', $item->imageFront('hero'))
        @slot('imgMobile', $item->imageFront('mobile_hero'))
    @endcomponent

    <div class="o-article__secondary-actions">
        {{-- Intentionally left blank for layout --}}
    </div>

    @if ($item->description)
        <div class="o-article__intro">
            @component('components.blocks._text')
                @slot('font', 'f-deck')
                @slot('tag', 'div')
                {!! $item->present()->description !!}
            @endcomponent
        </div>
    @endif

    <div class="o-article__body o-blocks o-blocks--with-sidebar">
        @if ($item->showAuthorsWithLinks())
            @component('components.blocks._text')
                @slot('font', 'f-tag-2')
                @slot('tag', 'div')
                {!! $item->showAuthorsWithLinks() !!}
            @endcomponent
            <hr>
        @endif

        @if ($item->abstract)
            @component('components.blocks._text')
                @slot('font', 'f-body-editorial-emphasis')
                @slot('variation', 'o-article--journal_abstract')
                @slot('tag', 'div')
                {!! $item->present()->abstract !!}
            @endcomponent
            <hr>
        @endif

        @php
        global $_collectedReferences;
        $_collectedReferences = [];

        global $_paragraphCount;
        $_paragraphCount = 0;
        @endphp

        {!! $item->renderBlocks(false, [], [
            'pageTitle' => $item->meta_title ?: $item->title,
        ]) !!}

        @component('partials._bibliography')
            @slot('notes', $_collectedReferences ?? null)
            @slot('references', $item->present()->references())
            @slot('citeAs', $item->present()->citeAs())
        @endcomponent
    </div>
</article>

@if (isset($featuredArticles) && $featuredArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($featuredArticles as $item)
            @component('components.molecules._m-listing----' . strtolower($item->type))
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '216px',
                        'small' => '216px',
                        'medium' => '18',
                        'large' => '13',
                        'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

<hr>

@include('components.organisms._o-publication-footer----journal')

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
