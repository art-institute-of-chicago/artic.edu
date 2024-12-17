@if(!isset($item))
    @formField('select', [
        'name' => "type",
        'label' => "Type",
        'native' => true,
        'options' => $typesList,
        'placeholder' => 'Select a type',
        'required' => true
    ])

    @formField('date_picker', [
        'name' => 'date_start',
        'label' => 'Start date',
        'withTime' => false,
        'required' => true
    ])

    @formField('date_picker', [
        'name' => 'date_end',
        'label' => 'End date',
        'withTime' => false,
        'required' => true
    ])

    <p>For a 1 day closure, use the same start and end date.</p>
@endif
