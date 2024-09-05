@include('twill::partials.create')

@formField('select', [
    'name' => 'article_type',
    'label' => 'Type',
    'placeholder' => 'Select a type',
    'options' => $types,
])
