@twillRepeaterTitle('Date Rule')
@twillRepeaterTrigger('Add Date Rule')
@twillRepeaterComponent('a17-block-date_rule')
@twillRepeaterMax('10')

<x-twill::select
    name='type'
    label='Type of rule'
    default='0'
    :options='\App\Models\DateRule::getRuleTypes()'
    :required='true'
/>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::date-picker
            name='start_date'
            label='Start Date'
            :withTime='false'
            :required='true'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::date-picker
            name='end_date'
            label='Ends'
            :withTime='false'
        />

        <x-twill::input
            name='ocurrencies'
            label='Or stop after the following amount of ocurrencies:'
            type='number'
            placeholder='1, 2, 3.... etc'
        />
    </x-slot:right>
</x-twill::formColumns>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::input
            name='every'
            label='Repeat every'
            type='number'
            placeholder='1, 2, 3.... etc'
            :required='true'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::select
            name='recurring_type'
            label='Days/Week/Month'
            default='0'
            :options='\App\Models\DateRule::getRecurringTypes()'
            :required='true'
        />
    </x-slot:right>
</x-twill::formColumns>

<x-twill::formCollapsedFields label='Edit admission' label='Edit weekly/monthly options'>

    <x-twill::formInlineCheckboxes label='If repeated weekly, which days?'>

        <x-twill::checkbox
            name='monday'
            label='Monday'
        />
        <x-twill::checkbox
            name='tuesday'
            label='Tuesday'
        />
        <x-twill::checkbox
            name='wednesday'
            label='Wednesday'
        />
        <x-twill::checkbox
            name='thursday'
            label='Thursday'
        />
        <x-twill::checkbox
            name='friday'
            label='Friday'
        />
        <x-twill::checkbox
            name='saturday'
            label='Saturday'
        />
        <x-twill::checkbox
            name='sunday'
            label='Sunday'
        />
    </x-twill::formInlineCheckboxes>

    <x-twill::select
        name='monthly_repeat_pattern'
        label='If repeated monthly, select a pattern'
        default='0'
        :options='\App\Models\DateRule::getMonthlyRepeat()'
    />
</x-twill::formCollapsedFields>
