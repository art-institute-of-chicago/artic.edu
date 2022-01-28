@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----journal')
        @slot('title', $item->present()->title ?? null)
        @slot('title_display', $item->present()->title_display ?? null)
        @slot('img', $item->imageFront('hero') ?? null)
        @slot('imgMobile', $item->imageFront('mobile_hero') ?? null)
        @slot('credit', $item->hero_caption ?? null)
        @slot('intro', $item->header_text ?? null)
        @slot('issueNumber', $item->issue_number ?? null)
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--journal-issue">
        @component('components.molecules._m-article-actions----journal-issue')
            @slot('issues', $issues)
            @slot('citeAs', $item->cite_as ?? null)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->welcome_note_display && $welcomeNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----publication')
                    @slot('description', $item->welcome_note_display)
                    @slot('articleLink', $welcomeNote->url)
                @endcomponent
            </div>
        @endif

        @if ($item->present()->articlesForLanding())
            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')
                @slot('cols_xsmall','1')
                @slot('cols_small','2')
                @slot('cols_medium','2')
                @slot('cols_large','2')
                @slot('cols_xlarge','2')
                @foreach ($item->present()->articlesForLanding() as $article)
                    @component('components.molecules._m-listing----publication')
                        @slot('variation', 'm-listing--journal')
                        @slot('href', $article->url)
                        @slot('image', $article->imageFront('hero'))
                        @slot('type', $article->present()->getArticleType())
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

<hr>

@include('components.organisms._o-publication-footer----journal')

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
@endsection
