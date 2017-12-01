<span class="m-date-select-range">
    @component('components.atoms._date-select-trigger')
        @if (isset($startHiddenInputName))
            @slot('hiddenInputName', $startHiddenInputName)
        @endif
        @if (isset($startHiddenInputId))
            @slot('hiddenInputId', $startHiddenInputId)
        @endif
        @slot('range', true)
        @slot('selectDateId', $startId)
        @slot('selectDateRole', 'start')
        @slot('selectDateLinkedId', $endId)
        {{ $startLabel }}
    @endcomponent
    @component('components.atoms._date-select-trigger')
        @if (isset($endHiddenInputName))
            @slot('hiddenInputName', $endHiddenInputName)
        @endif
        @if (isset($endHiddenInputId))
            @slot('hiddenInputId', $endHiddenInputId)
        @endif
        @slot('range', true)
        @slot('selectDateId', $endId)
        @slot('selectDateRole', 'end')
        @slot('selectDateLinkedId', $startId)
        {{ $endLabel }}
    @endcomponent
</span>
