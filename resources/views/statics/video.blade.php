@extends('layouts.app')

@section('content')

<article class="o-article o-article--video">

    @component('components.molecules._m-article-header')
        @slot('title', $article->title)
        @slot('date', $article->date)
        @slot('type', $article->type)
        @slot('intro', $article->intro)
    @endcomponent

    <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">
        @component('components.molecules._m-media')
            @slot('variation', 'o-blocks__block')
            @slot('item', $article->video)
        @endcomponent

        @component('components.blocks._blocks')
            @slot('editorial', ($article->articleType === 'editorial'))
            @slot('blocks', $article->blocks ?? null)
            @slot('dropCapFirstPara', ($article->articleType === 'editorial'))
        @endcomponent

        <div class="o-article__body-actions">
            @component('components.molecules._m-article-actions')
                @slot('articleType', $article->articleType)
            @endcomponent
        </div>
    </div>
</article>

@if ($article->relatedVideos)
    @component('components.molecules._m-title-bar')
        Related Videos
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedVideos as $item)
            @component('components.molecules._m-listing----article-minimal')
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

@component('components.organisms._o-recently-viewed')
    @slot('artworks',$article->recentlyViewedArtworks ?? null)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$article->interestedThemes ?? null)
@endcomponent

@endsection
