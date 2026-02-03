@extends('layouts.app')

@section('content')
    <div
        data-behavior="triggerMediaModal"
        style="display: block; background-color: #fff; height: 50px; width: 50px;"
    >
        <textarea style="display: none;">
            {!! $item->embed !!}
        </textarea>
    </div>
    @fragment('shorts-player')
        <div id="shorts-player">
            <div class="short-video previous-video">
                @if ($previousItem)
                    @component('components.atoms._link')
                        @slot('href', route('shorts.show', ['video' => $previousItem]))
                        @slot('behavior', 'getUrl')
                        @slot('dataHref', route('shorts.show', ['video' => $previousItem]) . '?player')
                        @component('components.molecules._m-media')
                            @slot('variation', 'variation--short')
                            @slot('item', [
                                'type' => 'image',
                                'size' => 'l',
                                'media' => ImageHelpers::youtubeItemAsArray($previousItem),
                                'hideCaption' => true,
                                'fullscreen' => false,
                            ])
                        @endcomponent
                    @endcomponent
                @endif
            </div>
            <div class="short-video current-video">
                @component('components.molecules._m-media')
                    @slot('variation', 'variation--short')
                    @slot('item', [
                        'type' => 'embed',
                        'size' => 'l',
                        'media' => [
                            'url' => $item->video_url,
                            'embed' => $item->embed,
                            'medias' => $item->medias,
                        ],
                        'hideCaption' => true,
                        'fullscreen' => false,
                    ])
                @endcomponent
            </div>
            <div class="short-video next-video">
                @if ($nextItem)
                    @component('components.atoms._link')
                        @slot('href', route('shorts.show', ['video' => $nextItem]))
                        @slot('behavior', 'getUrl')
                        @slot('dataHref', route('shorts.show', ['video' => $nextItem]) . '?player')
                        @component('components.molecules._m-media')
                            @slot('variation', 'variation--short')
                            @slot('item', [
                                'type' => 'image',
                                'size' => 'l',
                                'media' => ImageHelpers::youtubeItemAsArray($nextItem),
                                'hideCaption' => true,
                                'fullscreen' => false,
                            ])
                        @endcomponent
                    @endcomponent
                @endif
            </div>
        </div>
    @endfragment
@endsection
