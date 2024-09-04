@include('twill::partials.create')

@formField('select', [
    'name' => 'category',
    'label' => 'Category',
    'placeholder' => 'Select a category',
    'options' => $categories,
])
