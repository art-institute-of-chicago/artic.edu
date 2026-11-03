{{--
Usage:
    @component('components.organisms._o-tabbed-tombstone')
        @slot('tabs', $block['tabs'])
    @endcomponent

    Each tab is an array in the shape:
        [
            'id'     => 'overview',            // StringHelpers::getUtf8Slug()-safe slug
            'label'  => 'Overview',
            'kind'   => 'keyvalue'|'list'|'prose',
            'rows'   => [ ['key' => ..., 'value' => ..., 'kind' => 'linked', 'copy' => ...] | ['content' => ...] ],
            'copy'   => 'plain text payload for the copy button',
            'hasCopy' => true|false,
        ]

    Desktop renders a vertical tab rail + scrollable panels (with a copy affordance and a
    footer caption). Below medium the rail becomes an accordion driven by the plus/minus glyphs.
--}}
@php
    $hash = md5(uniqid(rand(), true));
    $tabs = $tabs ?? [];
    $isPrint = app('printservice')->isPrintMode();
@endphp
<div class="o-tabbed-tombstone" data-behavior="tabbedTombstone">
    <div class="o-tabbed-tombstone__rail" role="tablist" aria-orientation="vertical">
        @foreach ($tabs as $index => $tab)
            @php
                $tabKey = $tab['id'];
                $tabId = 'tabbed-tombstone-'.$hash.'-tab-'.$tabKey;
                $panelId = 'tabbed-tombstone-'.$hash.'-panel-'.$tabKey;
                $isActive = $index === 0;
            @endphp
            <div class="o-tabbed-tombstone__tab-row">
                <button
                    id="{{ $tabId }}"
                    class="o-tabbed-tombstone__tab{{ $isActive ? ' is-active' : '' }}"
                    type="button"
                    role="tab"
                    aria-selected="{{ $isActive ? 'true' : 'false' }}"
                    aria-controls="{{ $panelId }}"
                    tabindex="{{ $isActive ? '0' : '-1' }}"
                >
                    <span class="o-tabbed-tombstone__tab-label">{{ $tab['label'] }}</span>
                    <span class="o-tabbed-tombstone__tab-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                </button>
            </div>
        @endforeach
    </div>
    <div class="o-tabbed-tombstone__content">
        @foreach ($tabs as $index => $tab)
            @php
                $tabKey = $tab['id'];
                $tabId = 'tabbed-tombstone-'.$hash.'-tab-'.$tabKey;
                $panelId = 'tabbed-tombstone-'.$hash.'-panel-'.$tabKey;
                $isActive = $index === 0;
                $rows = $tab['rows'] ?? [];
                $hasLinkedRows = false;
                foreach ($rows as $row) {
                    if (($row['kind'] ?? null) === 'linked') {
                        $hasLinkedRows = true;
                        break;
                    }
                }
                $showPanelCopy = !empty($tab['hasCopy']) && !$hasLinkedRows;
            @endphp
            <div
                id="{{ $panelId }}"
                class="o-tabbed-tombstone__panel{{ $isActive ? ' is-active' : '' }}"
                role="tabpanel"
                aria-labelledby="{{ $tabId }}"
                data-copy="{{ $tab['copy'] ?? '' }}"
                @if (! $isActive && ! $isPrint) hidden @endif
            >
                @if ($showPanelCopy)
                    <button
                        type="button"
                        class="o-tabbed-tombstone__copy"
                        aria-label="Copy {{ $tab['label'] }} information"
                        data-copy-value="{{ $tab['copy'] ?? '' }}"
                    >
                        <svg class="icon--copy--24"><use xlink:href="#icon--copy--24" /></svg>
                        <span class="sr-only">Copy {{ $tab['label'] }} information</span>
                    </button>
                @endif

                <div class="o-tabbed-tombstone__panel-scroll">
                    @if ($tab['kind'] === 'keyvalue')
                        <dl class="o-tabbed-tombstone__rows">
                            @foreach ($rows as $row)
                                <div class="o-tabbed-tombstone__row">
                                    <dt class="o-tabbed-tombstone__label">{{ $row['key'] }}</dt>
                                    <dd class="o-tabbed-tombstone__value">
                                        {!! $row['value'] ?? '' !!}
                                        @if (($row['kind'] ?? null) === 'linked')
                                            <button
                                                type="button"
                                                class="o-tabbed-tombstone__row-copy"
                                                aria-label="Copy {{ $row['key'] }}"
                                                data-copy-value="{{ $row['copy'] ?? '' }}"
                                            >
                                                <svg class="icon--copy--24"><use xlink:href="#icon--copy--24" /></svg>
                                                <span class="sr-only">Copy {{ $row['key'] }}</span>
                                            </button>
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    @elseif ($tab['kind'] === 'list')
                        <ul class="o-tabbed-tombstone__list">
                            @foreach ($rows as $row)
                                <li class="o-tabbed-tombstone__list-item">{!! $row['content'] ?? '' !!}</li>
                            @endforeach
                        </ul>
                    @else
                        @foreach ($rows as $row)
                            <p class="o-tabbed-tombstone__prose">{!! $row['content'] ?? '' !!}</p>
                        @endforeach
                    @endif
                </div>
                <div class="o-tabbed-tombstone__panel-fade" aria-hidden="true"></div>
            </div>
        @endforeach

        @if (! empty($caption))
            <div class="o-tabbed-tombstone__footer">
                {!! $caption !!}
            </div>
        @endif
    </div>
</div>
