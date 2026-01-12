<div class="o-tabbed-details" style="--tab-count: {{ $tabCount }}">
    @for ($tabIndex = 1; $tabIndex <= $tabCount; $tabIndex++)
        <details name="tabbed-details" style="--tab: {{ $tabIndex }}" @if ($tabIndex === 1) open @endif>
            <summary>{{ ${'tab' . $tabIndex}->attributes->get('title') }}</summary>
            <div class="o-tabbed-details__content">
                {{ ${'tab' . $tabIndex} }}
            </div>
        </details>
    @endfor
</div>
