@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'required' => true
])

@component('twill::partials.form.utils._collapsed_fields', ['label' => 'Edit admission'])
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Date',
        'required' => true
    ])

    @formField('input', [
        'name' => 'time_start',
        'label' => 'Opening time',
        'required' => true
    ])

    @formField('input', [
        'name' => 'time_end',
        'label' => 'Closing time',
        'required' => true
    ])

    @formField('input', [
        'name' => 'copy',
        'label' => 'Copy',
        'type' => 'textarea',
        'required' => true
    ])
@endcomponent
