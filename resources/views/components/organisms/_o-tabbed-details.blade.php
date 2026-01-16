{{--
Usage:
    <x-tabbed-details :tab-count="2">
        <x-slot name="tab1" title="Render Arbitrary Markup">
            <span>Hello!</span>
        </x-slot>
        <x-slot name="tab2" title="Do Twill Stuff">
            <div>{!! $item->renderBlocks() !!}</div>
        </x-slot>
    </x-tabbed-details>
--}}
<div class="o-tabbed-details" style="--tab-count: {{ $tabCount }}">
    @for ($tabIndex = 1; $tabIndex <= $tabCount; $tabIndex++)
        <details
            name="tabbed-details"
            class="o-tabbed-details__tab"
            style="--tab: {{ $tabIndex }}"
            @if ($tabIndex === 1) open @endif
        >
            <summary class="o-tabbed-details__tab-title">
                {{ ${'tab' . $tabIndex}->attributes->get('title') }}
            </summary>
            <div class="o-tabbed-details__tab-content">
                {{ ${'tab' . $tabIndex} }}
            </div>
        </details>
    @endfor
    <div class="o-tabbed-details__spacer"></div>
</div>
