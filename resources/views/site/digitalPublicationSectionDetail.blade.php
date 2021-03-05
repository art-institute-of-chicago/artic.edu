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
                {!! $item->digitalPublication->title_display ?? $item->digitalPublication->title !!}
            @endcomponent
        </button>
    </div>

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item->digitalPublication)
            @slot('currentSection', $item)
            @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
        @endcomponent
    </div>

    @if ($item->type == \App\Models\DigitalPublicationSection::TEXT)
        @component('components.molecules._m-article-header----journal-article')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('img', $item->imageFront('hero'))
        @endcomponent
    @else
        @component('components.molecules._m-article-header')
            @slot('headerType', 'generic')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display ?? null) {{-- TODO: Populate this? --}}
        @endcomponent
    @endif

    <div class="o-article__secondary-actions">
        {{-- Intentionally left blank for layout --}}
    </div>

    @if ($item->heading)
    <div class="o-article__intro">
      @component('components.blocks._text')
          @slot('font', 'f-body-editorial')
          @slot('tag', 'div')
          {!! $item->present()->heading !!}
      @endcomponent
    </div>
    @endif

    <div class="o-article__body o-blocks o-blocks--with-sidebar {{ $item->type != \App\Models\DigitalPublicationSection::TEXT ? "o-article__body--no-top-border f-body" : "" }}">
        @if ($item->type == \App\Models\DigitalPublicationSection::TEXT)
            @if ($item->showAuthorsWithLinks())
                @component('components.blocks._text')
                    @slot('font', 'f-tag-2')
                    @slot('variation', 'author-links')
                    @slot('tag', 'div')
                    {!! $item->showAuthorsWithLinks() !!}
                @endcomponent
            @endif
        @endif

        @php
        if ($item->type == \App\Models\DigitalPublicationSection::TEXT) {
            global $_collectedReferences;
            $_collectedReferences = [];

            global $_paragraphCount;
            $_paragraphCount = 0;

            global $_figureCount;
            $_figureCount = 0;
        }
        @endphp

        {!! $item->renderBlocks(false, [], [
            'pageTitle' => $item->meta_title ?: $item->title,
        ]) !!}

        @if (isset($_collectedReferences) && sizeof($_collectedReferences))
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
            ])
                Notes
            @endcomponent
            @component('components.blocks._blocks')
                @slot('blocks',
                    [
                        [
                            'type' => 'references',
                            'items' => $_collectedReferences
                        ]
                    ])
            @endcomponent
        @endif

        @if ($item->bibliography)
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
            ])
                Bibliography
            @endcomponent
            @php
                // Add `f-secondary` class to <ul> and <ol> tags
                $dom = new DomDocument();
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $item->bibliography, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $xpath = new DOMXpath($dom);
                $nodes = $xpath->query('//ol | //ul');

                foreach($nodes as $node) {
                    $node->setAttribute('class', 'f-secondary');
                }
                $bibliography = $dom->saveHTML($dom);
            @endphp
            {!! $bibliography !!}
        @endif

        @if ($item->cite_as)
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
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
