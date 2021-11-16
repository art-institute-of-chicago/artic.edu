@twillRepeaterTitle('Museum Address')
@twillRepeaterTrigger('Add Museum Address')
@twillRepeaterComponent('a17-block-locations')
@twillRepeaterMax('10')

@formField('input', [
    'name' => 'name',
    'label' => 'Entrance',
    'required' => true
])

@component('twill::partials.form.utils._collapsed_fields', ['label' => 'Edit location'])
    @formField('input', [
        'name' => 'street',
        'label' => 'Street',
    ])
    @formField('input', [
        'name' => 'address',
        'label' => 'Address',
    ])

    @formField('input', [
        'name' => 'city',
        'label' => 'City',
    ])
    @formField('input', [
        'name' => 'state',
        'label' => 'State',
    ])
    @formField('input', [
        'name' => 'zip',
        'label' => 'ZIP code',
    ])
@endcomponent
