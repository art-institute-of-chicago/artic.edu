@php
    use App\Enums\DigitalPublicationArticleType;
@endphp

@extends('layouts.app')

@section('content')

@if ($bgcolor ?? false)
<style>
    .m-article-header--digital-publication-article ~ .m-article-header__text::before,
    .m-article-actions--publication__logo.u-show\@medium-::before {
        background-color: {{ isset($bgcolor) ? $bgcolor : null  }};
    }
</style>
@endif

<article class="o-article">
    @if ($item->article_type == DigitalPublicationArticleType::Contributions)
        @component('components.molecules._m-article-header----digital-publication-article')
            @slot('bgcolor', isset($bgcolor) ? $bgcolor : null )
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('pub_title', $item->digitalPublication->present()->title)
            @slot('pub_title_display', $item->digitalPublication->present()->title_display)
            @slot('img', $item->imageFront('hero'))
            @slot('imgMobile', $item->imageFront('mobile_hero'))
        @endcomponent
    @endif

    @component('components.molecules._m-sidebar-toggle')
        @slot('title', $item->digitalPublication->title_display ?? $item->digitalPublication->title)
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--digital-publication">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item->digitalPublication)
            @slot('currentArticle', $item)
            @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
            @slot('citeAs', $item->cite_as)
        @endcomponent
    </div>

    @if ($item->article_type != DigitalPublicationArticleType::Contributions && $item->article_type != DigitalPublicationArticleType::Entry)
        @component('components.molecules._m-article-header')
            @slot('headerType', 'generic')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display ?? null) {{-- WEB-2244: Populate this? --}}
        @endcomponent
    @endif

    <div class="o-article__secondary-actions o-article__secondary-actions--empty">
        {{-- Intentionally left blank for layout --}}
    </div>

    @if ($item->article_type !== DigitalPublicationArticleType::Entry)
        <div class="m-article-header__text u-show@large+">
            @component('components.atoms._title')
                @slot('tag', 'h1')
                @slot('font', 'f-headline-editorial')
                @slot('itemprop', 'name')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display ?? null)
                @slot('variation', 'contrast-text')
            @endcomponent
        </div>
    @endif

    @if ($item->heading)
    <div class="o-article__intro">
      @component('components.blocks._text')
          @slot('font', 'f-body-editorial')
          @slot('tag', 'div')
          {!! $item->present()->heading !!}
      @endcomponent
    </div>
    @endif

    <div class="o-article__body o-blocks o-blocks--with-sidebar">
        @if ($item->article_type !== DigitalPublicationArticleType::Entry)
            <div class="m-article-header__text u-show@medium-">
                @component('components.atoms._title')
                    @slot('tag', 'h1')
                    @slot('font', 'f-headline-editorial')
                    @slot('itemprop', 'name')
                    @slot('title', $item->present()->title)
                    @slot('title_display', $item->present()->title_display ?? null)
                @endcomponent
            </div>
        @endif

        @if ($item->showAuthorsWithLinks() && $item->article_type == DigitalPublicationArticleType::Contributions)
            @component('components.blocks._text')
                @slot('font', 'f-tag-2')
                @slot('variation', 'author-links')
                @slot('tag', 'div')
                {!! $item->showAuthorsWithLinks() !!}
            @endcomponent
        @endif

        @php
        switch ($item->article_type) {
            case DigitalPublicationArticleType::Contributions:
            case DigitalPublicationArticleType::Entry:
                global $_collectedReferences;
                $_collectedReferences = [];

                global $_paragraphCount;
                $_paragraphCount = 0;
                break;
        }

        global $_allowAdvancedModalFeatures;
        $_allowAdvancedModalFeatures = true;

        @endphp

        {!! $item->renderBlocks(false, [], [
            'pageTitle' => $item->meta_title ?: $item->title,
        ]) !!}

        @if ($item->showAuthorsWithLinks() && $item->article_type == DigitalPublicationArticleType::Entry)
            @component('components.blocks._text')
                @slot('font', 'f-tag-2')
                @slot('variation', 'author-links')
                @slot('tag', 'div')
                Entry by {!! $item->showAuthorsWithLinks() !!}
            @endcomponent
        @endif

        @component('partials._bibliography')
            @slot('notes', $_collectedReferences ?? null)
            @slot('references', $item->present()->references())
            @slot('citeAs', $item->present()->citeAs())
        @endcomponent
    </div>
</article>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/layeredImageViewer.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
