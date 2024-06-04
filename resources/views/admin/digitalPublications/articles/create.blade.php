@include('twill::partials.create')

@formField('select', [
    'name' => 'type',
    'label' => 'Type',
    'placeholder' => 'Select a type',
    'options' => $types,
])
