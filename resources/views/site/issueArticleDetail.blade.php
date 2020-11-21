@extends('layouts.app')

@section('content')

<article class="o-article">
    <div class="m-journal-mobile u-hide@large+">
        @component('components.atoms._link')
            @slot('font', '')
            @slot('href', 'foo')

            @component('components.blocks._text')
                @slot('tag', 'span')
                @slot('font', 'f-list-1')
                Art Institue Review
            @endcomponent
        @endcomponent
    </div>

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions----journal-article')
            @slot('item', $item)
        @endcomponent
    </div>

    @component('components.molecules._m-article-header----journal-article')
        @slot('title', $item->present()->title)
        @slot('title_display', $item->present()->title_display)
        @slot('img', $item->imageFront('hero'))
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

        // global $_paragraphCount;
        // $_paragraphCount = 0;

        global $_figureCount;
        $_figureCount = 0;
        @endphp

        {!! $item->renderBlocks(false, [], [
            'pageTitle' => $item->meta_title ?: $item->title,
        ]) !!}

        @if (sizeof($_collectedReferences))
            @component('components.organisms._o-accordion')
                @slot('variation', 'o-accordion--section o-blocks__block')
                @slot('items', array(
                    array(
                        'title' => "References",
                        'active' => true,
                        'blocks' => array(
                            array(
                                "type" => 'references',
                                "items" => $_collectedReferences
                            ),
                        ),
                    ),
                ))
                @slot('loopIndex', 'references')
            @endcomponent
        @endif
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
                    'sizes' => aic_imageSizes(array(
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
