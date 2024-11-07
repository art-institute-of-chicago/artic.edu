{{--
    Expects $items to be in the format:
    [
        [
            'title' => 'Level 1 title',
            'items' => [
                [
                    'title' => 'Level 2 title',
                    'items' => [
                        [
                            'title' => 'Level 3 item',
                            'url' => 'https://some.link',
                        ],
                        [
                            'title' => 'Another level 3 item',
                            'url' => 'https://some-other.link',
                        ]
                    ]
                ],
            ],
        ]
    ]
--}}
<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        @if (isset($item['items']) && count($item['items']) > 0)
            <h3 class="o-accordion__title">
                <button
                    id="{{ StringHelpers::getUtf8Slug($item['title']) }}"
                    class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}"
                    tabindex="0"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}
                    aria-expanded="{{ (isset($active) and $active) ? 'true' : 'false' }}"
                >
                    {!! $item['title'] !!}
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                </button>
            </h3>
            <div
                id="panel_{{ StringHelpers::getUtf8Slug($item['title']) }}"
                class="o-accordion__panel"
                aria-labelledby="{{ StringHelpers::getUtf8Slug($item['title']) }}"
                aria-hidden="{{ (isset($active) and $active) ? 'false' : 'true' }}"
            >
                @component('components.organisms._o-accordion-tree')
                    @slot('variation', $variation)
                    @slot('titleFont', $titleFont)
                    @slot('title', $item['title'])
                    @slot('items', $item['items'])
                @endcomponent
            </div>
        @else
            <span class="m-link-list__item o-accordion__panel-content">
                <a
                    class="m-link-list__trigger f-secondary"
                    href="{{ $item['url'] }}"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}
                >
                    <span class="m-link-list__label">{!! $item['title'] !!}</span>
                </a>
            </span>
        @endif
    @endforeach
</div>
