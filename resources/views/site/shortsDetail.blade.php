@extends('layouts.app')

@section('content')
    @fragment('shorts-player')
        <div class="g-modal__logo">
            <svg aria-hidden="true">
                <use xlink:href="#icon--logo--outline--80"></use>
            </svg>
        </div>
        <div id="shorts-player">
            <ul id="shorts-list">
                @foreach ($previousItems as $index => $previousItem)
                    <li
                        id="short-{{ $previousItem->youtube_id }}"
                        @class([
                            'short-video',
                            'previous-video' => $index + 1 == $previousItems->count(),
                        ])
                        {!! $dataAttributes[$previousItem->id] !!}
                    >
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
                    </li>
                @endforeach
                <li
                    id="short-{{ $item->youtube_id }}"
                    class="short-video current-video"
                    {!! $dataAttributes[$item->id] !!}
                >
                    <figure
                        class="m-media m-media--l variation--short"
                        data-type="embed"
                    >
                    <button class="b-drag-scroll__btn-prev btn arrow-link arrow-link--back">
                        <svg class="icon--arrow--64">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use>
                        </svg>
                    </button>
                        <div
                            class="m-media__img m-media__img--embed"
                            {{-- data-behavior="shortsPlayer" --}}
                            aria-label="Media embed, click to play"
                            tabindex="0"
                        >
                            {!! $embed !!}
                        </div>
                    <button class="b-drag-scroll__btn-next btn arrow-link">
                        <svg class="icon--arrow--64">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use>
                        </svg>
                    </button>
                    </figure>
                    @component('components.molecules._m-media')
                        @slot('variation', 'variation--short')
                        @slot('item', [
                            'type' => 'image',
                            'size' => 'l',
                            'media' => ImageHelpers::youtubeItemAsArray($item),
                            'hideCaption' => true,
                            'fullscreen' => false,
                        ])
                    @endcomponent
                </li>
                @foreach ($nextItems as $index => $nextItem)
                    <li
                        id="short-{{ $nextItem->youtube_id }}"
                        @class([
                            'short-video',
                            'next-video' => $index == 0,
                        ])
                        {!! $dataAttributes[$nextItem->id] !!}
                    >
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
                    </li>
                @endforeach
            </ul>
        </div>
    @endfragment
@endsection
