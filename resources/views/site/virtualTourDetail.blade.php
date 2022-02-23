@extends('layouts.app')

@section('content')

    <article class="o-article o-article--video">

        <div class="o-article__primary-actions o-article__primary-actions--video">
            @component('components.atoms._title')
                @slot('tag','p')
                @slot('font', 'f-tag-2')
                Virtual tour
            @endcomponent

            @component('components.molecules._m-article-actions')
                @slot('articleType', 'video')
            @endcomponent
        </div>

        @component('components.molecules._m-article-header')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('formattedDate', $item->present()->date)
        @endcomponent

        <div class="o-article__body o-blocks">
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', [
                    'type' => 'virtualtour',
                    'size' => 'l',
                    'media' => [
                        'vtourxml' => $item->getVirtualTourXML(),
                    ],
                    'poster' => $item->imageFront('hero'),
                    'hideCaption' => true,
                    'fullscreen' => false,
                ])
            @endcomponent
        </div>

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
            {!! $item->renderBlocks(false, [], [
                'pageTitle' => $item->title
            ]) !!}
        </div>
    </article>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/virtualTour.js')}}"></script>
    <script src="/virtual-tours/tour.js"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
