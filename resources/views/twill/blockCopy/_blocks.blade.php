@php
    // Group rows by block editor (null and 'default' are the same Twill group).
    $groups = [];
    foreach ($blocks as $block) {
        $editor = $block['editor'] ?? null;
        $key = $editor ?? '';
        if (!isset($groups[$key])) {
            $groups[$key] = ['label' => $key === '' ? 'default' : $key, 'blocks' => []];
        }
        $groups[$key]['blocks'][] = $block;
    }
    $multiGroup = count($groups) > 1;
@endphp
@forelse($groups as $group)
    @if($multiGroup)
        <li class="bc__groupLabel">{{ $group['label'] }}</li>
    @endif
    @foreach($group['blocks'] as $block)
        @php
            $parts = [];
            if ($block['children'] > 0) {
                $parts[] = $block['children'] . ' children';
            }
            if ($block['media'] > 0) {
                $parts[] = $block['media'] . ' images';
            }
            $actionable = $column === 'source' && $targetChosen && $block['allowed'] !== false;
        @endphp
        <li class="bc__row @if($block['is_new']) bc__row--new @endif"@if($column === 'target') draggable="true" data-bc-reorder data-block-id="{{ $block['id'] }}" data-bc-editor="{{ $block['editor'] ?? '' }}"@elseif($actionable) draggable="true" data-bc-drag="{{ $block['id'] }}"@endif>
            @if($column === 'target')
                <span class="bc__handle" tabindex="0" role="button" aria-label="Reorder block"><svg width="8" height="17" aria-hidden="true"><use xlink:href="#icon--drag"></use></svg></span>
            @elseif($actionable)
                <span class="bc__handle" tabindex="0" role="button" aria-label="Copy block to target"><svg width="8" height="17" aria-hidden="true"><use xlink:href="#icon--drag"></use></svg></span>
            @endif
            <span class="bc__pos">{{ $block['position'] }}</span>
            <span class="bc__badge">{{ $block['type'] }}</span>
            <span class="bc__preview">{{ $block['preview'] }}</span>
            <span class="bc__id">#{{ $block['id'] }}</span>
            <span class="bc__meta">{{ implode(' &middot; ', $parts) }}</span>
            <span class="bc__action">
                @if($column === 'target')
                    @if($block['is_new'])
                        <span class="bc__chip">Just pasted</span>
                    @endif
                @elseif($block['allowed'] === false)
                    <span class="bc__hint">Not allowed on target</span>
                @elseif(!$targetChosen)
                    <span class="bc__hint">Pick a target first</span>
                @endif
            </span>
        </li>
    @endforeach
@empty
    <li class="bc__empty">No blocks on this record yet.</li>
@endforelse
