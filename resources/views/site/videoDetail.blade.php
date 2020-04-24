@extends('layouts.app')

@section('content')

    <article class="o-article o-article--video">

        <div class="o-article__primary-actions">
            @component('components.molecules._m-article-actions')
                @slot('articleType', 'video')
            @endcomponent
        </div>

        @component('components.molecules._m-article-header')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('formattedDate', $item->present()->date)
        @endcomponent

        @if ($item->heading)
            <div class="o-article__intro">
              @component('components.blocks._text')
                  @slot('font', 'f-deck')
                  @slot('tag', 'div')
                  {!! $item->present()->heading !!}
              @endcomponent
            </div>
        @endif

        <div class="o-article__body o-blocks">
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', [
                    'type' => 'embed',
                    'size' => 'l',
                    'media' => $item->toArray(),
                    'poster' => $item->imageFront('hero'),
                    'hideCaption' => true,
                    'fullscreen' => false,
                ])
            @endcomponent

            {!! $item->renderBlocks(false, [], [
                'pageTitle' => $item->title
            ]) !!}
        </div>
    </article>

    @if ($relatedVideos->count() > 0)
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
            @foreach ($relatedVideos as $item)
                @component('components.molecules._m-listing----article-minimal')
                    @slot('href', route('videos.show', $item))
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
@endsection
