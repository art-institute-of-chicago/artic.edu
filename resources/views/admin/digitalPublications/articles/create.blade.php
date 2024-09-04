@include('twill::partials.create')

@formField('select', [
    'name' => 'category',
    'label' => 'Type',
    'placeholder' => 'Select a type',
    'options' => $categories,
])
