<span class="m-date-select-range">
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'dateStart')
        @slot('hiddenInputId', 'dateStart')
        @slot('range', true)
        @slot('selectDateId', 'cal01')
        @slot('selectDateRole', 'start')
        @slot('selectDateLinkedId', 'cal02')
        Start date
    @endcomponent
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'dateEnd')
        @slot('hiddenInputId', 'dateEnd')
        @slot('range', true)
        @slot('selectDateId', 'cal02')
        @slot('selectDateRole', 'end')
        @slot('selectDateLinkedId', 'cal01')
        End date
    @endcomponent
</span>
