@twillRepeaterTitle('Museum Address')
@twillRepeaterTrigger('Add Museum Address')
@twillRepeaterComponent('a17-block-locations')
@twillRepeaterMax('10')

<x-twill::input
    name='name'
    label='Entrance'
    :required='true'
/>

@component('twill::partials.form.utils._collapsed_fields', ['label' => 'Edit location'])
    <x-twill::input
        name='street'
        label='Street'
    />
    <x-twill::input
        name='address'
        label='Address'
    />

    <x-twill::input
        name='city'
        label='City'
    />
    <x-twill::input
        name='state'
        label='State'
    />
    <x-twill::input
        name='zip'
        label='ZIP code'
    />
    <x-twill::input
        name='directions_link'
        label='Directions Link'
    />
@endcomponent
