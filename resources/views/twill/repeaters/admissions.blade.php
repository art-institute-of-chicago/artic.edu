@twillRepeaterTitle('Admission')
@twillRepeaterTrigger('Add admission')
@twillRepeaterComponent('a17-block-admissions')
@twillRepeaterMax('10')

<x-twill::input
    name='title'
    label='Title'
    :required='true'
/>

<x-twill::formCollapsedFields label='Edit admission'>
    <x-twill::date-picker
        name='date'
        label='Date'
        :required='true'
    />

    <x-twill::input
        name='time_start'
        label='Opening time'
        :required='true'
    />

    <x-twill::input
        name='time_end'
        label='Closing time'
        :required='true'
    />

    <x-twill::input
        name='copy'
        label='Copy'
        type='textarea'
        :required='true'
    />
</x-twill::formCollapsedFields>
