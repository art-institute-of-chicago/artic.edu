@php
    use App\Enums\DigitalPublicationArticleType;
@endphp

@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----feature')
        @slot('variation', 'm-article-header--digital-publication')
        @slot('title', $item->present()->title)
        @slot('title_display', $item->present()->headerTitle())
        @slot('subtitle_display', $item->present()->headerSubtitle())
        @slot('img', $item->imageFront('listing'))
        @slot('imgMobile', $item->imageFront('mobile_listing'))
        @slot('credit', $item->hero_caption ?? null)
        @slot('editorial', true)
        @slot('bgcolor', $item->bgcolor)
    @endcomponent

    @component('components.molecules._m-sidebar-toggle')
        @slot('title', 'Table of Contents')
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--digital-publication">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item)
            @slot('isLogoAnimated', true)
            @slot('citeAs', $item->cite_as)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->welcome_note_display && $welcomeNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----publication')
                    @slot('description', $item->welcome_note_display)
                    @slot('articleLink', $welcomeNote->present()->getArticleUrl($item))
                @endcomponent
            </div>
        @endif

        @if ($item->present()->hasArticles(DigitalPublicationArticleType::Contributions->value))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                {{ DigitalPublicationArticleType::Contributions->name }}
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')
                @slot('cols_xsmall','1')
                @slot('cols_small','2')
                @slot('cols_medium','2')
                @slot('cols_large','2')
                @slot('cols_xlarge','2')
                @foreach ($item->present()->getArticles(DigitalPublicationArticleType::Contributions->value) as $article)
                    @component('components.molecules._m-listing----publication')
                        @slot('variation', 'm-listing--journal')
                        @slot('href', $article->present()->getArticleUrl($item))
                        @slot('image', $article->imageFront('hero'))
                        @slot('type', $article->present()->label)
                        @slot('title', $article->present()->title)
                        @slot('title_display', $article->present()->title_display)
                        @slot('list_description', $article->present()->list_description)
                        @slot('author_display', $article->showAuthors())
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

        @if ($item->present()->hasArticles(DigitalPublicationArticleType::Works->value))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                {{ DigitalPublicationArticleType::Works->name }}
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')

                @foreach ($item->present()->getArticles(DigitalPublicationArticleType::Works->value) as $article)
                    @component('components.molecules._m-listing----publication')
                        @slot('variation', 'm-listing--work')
                        @slot('href', $article->present()->getArticleUrl($item))
                        @slot('image', $article->imageFront('hero'))
                        @slot('type', $article->present()->label)
                        @slot('title', $article->present()->title)
                        @slot('title_display', $article->present()->title_display)
                        @slot('list_description', $article->present()->list_description)
                        @slot('author_display', $article->showAuthors())
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

        @if (isset($item->sponsor_display))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                Sponsors
            @endcomponent

            {!! $item->sponsor_display !!}
        @endif

        @if ($item->cite_as)
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                How to Cite
            @endcomponent

            {!! $item->cite_as !!}
        @endif
    </div>
</article>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
@endsection
