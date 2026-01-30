@extends('layouts.app')

@section('content')
    @if (isset($playlist))
        <div class="playlist-title">
            Playlist: {{ $playlist->title }}
        </div>
        @component('components.atoms._hr')@endcomponent
    @endif
    <article @class([
        'o-article o-article--video',
        'video-is-short' => $item->is_short,
    ])>
        <div class="o-article__header">
            @component('components.molecules._m-article-header')
                @slot('variation', $item->is_short ? 'variation--short' : 'variation--video')
                @slot('headerType', 'video')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            @component('components.molecules._m-media')
                @slot('variation', $item->is_short ? 'variation--short' : 'variation--video')
                @slot('item', [
                    'type' => 'embed',
                    'size' => 'l',
                    'media' => [
                        'url' => $item->video_url,
                        'embed' => $item->embed,
                        'medias' => $item->medias,
                    ],
                    'poster' => $item->is_short
                        ? null
                        : ($item->imageFront('hero') ?? ImageHelpers::youtubeItemAsArray($item)),
                    'hideCaption' => true,
                    'fullscreen' => false,
                ])
            @endcomponent
            @if (isset($playlist))
                @component('components.organisms._o-playlist')
                    @slot('playlist', $playlist)
                    @slot('currentVideo', $item)
                @endcomponent
            @endif
        </div>
        <div class="o-article__body o-blocks">
            @if ($item->heading)
                <div class="o-article__intro">
                @component('components.blocks._text')
                    @slot('font', 'f-deck')
                    @slot('tag', 'div')
                    {!! $item->present()->heading !!}
                @endcomponent
                </div>
            @endif
            <x-tabbed-details :tab-count="2">
                <x-slot name="tab1" title="Info">
                    <div class="o-article__content o-blocks">
                        {!! $item->renderBlocks(data: [
                            'pageTitle' => $item->title
                        ]) !!}
                    </div>
                </x-slot>
                <x-slot name="tab2" title="Transcript">
                    @if($transcript)
                        <h3>Transcript</h3>
                        {!! $transcript !!}
                    @else
                        <p class="video-transcript">Sorry, the transcript for this video is not yet available</p>
                    @endif
                </x-slot>
            </x-tabbed-details>
        </div>
    </article>

    @if ($relatedVideos->count() > 0)
        <div class="o-article__related o-article__related--videos">
            @component('components.molecules._m-title-bar')
                Related Videos
            @endcomponent
            @component('components.organisms._o-grid-listing')
                @slot(
                    'variation',
                    'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small'
                )
                @slot('cols_medium','4')
                @slot('cols_large','4')
                @slot('cols_xlarge','4')
                @slot('behavior','dragScroll')
                @foreach ($relatedVideos as $video)
                    @component('components.molecules._m-listing----grid-item')
                        @slot('url', $video->url ?? '')
                        @slot('label', $video->duration_display ?? '')
                        @slot('labelPosition', 'overlay')
                        @slot('tag', $video->is_short ? 'Short' : 'Video')
                        @slot('title', $video->title ?? '')
                        @slot('image', ['src' => $video->thumbnail_url ?? ''])
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
        </div>
    @endif
@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
