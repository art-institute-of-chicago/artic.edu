<div class="g-modal__logo">
    <svg aria-hidden="true">
        <use xlink:href="#icon--logo--outline--80"></use>
    </svg>
</div>
<div id="shorts-player">
    <ul id="shorts-list">
        @foreach ($previousItems as $index => $previousItem)
            <li
                id="{{ $previousItem->id }}"
                @class([
                    'short-video',
                    'previous-video' => $loop->last,
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
                @if($loop->last)
                    <button class="previous-arrow btn arrow-link arrow-link--back">
                        <svg class="icon--arrow--64">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use>
                        </svg>
                    </button>
                @endif
            </li>
        @endforeach
        <li
            id="{{ $item->id }}"
            class="short-video current-video"
            {!! $dataAttributes[$item->id] !!}
        >
            @if($nextItems->count() == 0)
                <button class="next-arrow btn arrow-link" style="display: none">
                    <svg class="icon--arrow--64">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use>
                    </svg>
                </button>
            @endif
            <figure
                class="m-media m-media--l variation--short"
                data-type="embed"
            >
                <div
                    class="m-media__img m-media__img--embed"
                    aria-label="Media embed, click to play"
                    tabindex="0"
                >
                    {!! $embed !!}
                </div>
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
            @if($previousItems->count() == 0)
                <button class="previous-arrow btn arrow-link arrow-link--back" style="display: none">
                    <svg class="icon--arrow--64">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use>
                    </svg>
                </button>
            @endif
        </li>
        @foreach ($nextItems as $index => $nextItem)
            <li
                id="{{ $nextItem->id }}"
                @class([
                    'short-video',
                    'next-video' => $loop->first,
                ])
                {!! $dataAttributes[$nextItem->id] !!}
            >
                @if($loop->first)
                    <button class="next-arrow btn arrow-link">
                        <svg class="icon--arrow--64">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use>
                        </svg>
                    </button>
                @endif
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
