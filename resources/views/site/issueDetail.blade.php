@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----journal')
        @slot('title', $item->present()->title ?? null)
        @slot('title_display', $item->present()->title_display ?? null)
        @slot('img', $item->imageFront('hero') ?? null)
        @slot('credit', $item->hero_caption ?? null)
        @slot('intro', $item->header_text ?? null)
        @slot('issueNumber', $item->issue_number ?? null)
    @endcomponent

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->present()->editorsNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note')
                    @slot('title', $item->present()->editorsNote->present()->shortTitle)
                    @slot('description', $item->present()->editorsNote->present()->listDescription)
                    @slot('issueNumber', $item->issue_number ?? null)
                    @slot('articleLink', $item->present()->editorsNote->url)
                @endcomponent
            </div>
        @endif

        @if ($item->present()->articlesForLanding)
            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')
                @slot('cols_xsmall','1')
                @slot('cols_small','2')
                @slot('cols_medium','2')
                @slot('cols_large','2')
                @slot('cols_xlarge','2')
                @foreach ($item->present()->articlesForLanding as $item)
                    @component('components.molecules._m-listing----journal')
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

    </div>

</article>

<hr>

@include('components.organisms._o-journal-footer')

@endsection
