@extends('layouts.app')

@section('content')

<article class="o-article">
    <div class="m-journal-mobile u-hide@large+">
        <button data-behavior="showStickySidebar" aria-label="Show publication navigation">
            <svg class="icon--menu--24">
                <use xlink:href="#icon--menu--24" />
            </svg>
            @component('components.blocks._text')
                @slot('tag', 'span')
                @slot('font', 'f-list-1')
                [Publication name]
            @endcomponent
        </button>
    </div>

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions----digital-publication-section')
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

    <div class="o-article__body o-blocks o-blocks--with-sidebar">
        @if ($item->showAuthorsWithLinks())
            @component('components.blocks._text')
                @slot('font', 'f-tag-2')
                @slot('tag', 'div')
                {!! $item->showAuthorsWithLinks() !!}
            @endcomponent
            <hr>
        @endif

        @php
        global $_collectedReferences;
        $_collectedReferences = [];

        global $_paragraphCount;
        $_paragraphCount = 0;

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

        @if ($item->cite_as)
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
            ])
                Recommended Citation
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                @slot('tag', 'div')
                {!! $item->cite_as !!}
            @endcomponent
        @endif
    </div>
</article>

@endsection
