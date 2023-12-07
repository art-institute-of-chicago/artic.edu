@include('admin.partials.create')

@formField('select', [
    'name' => 'type',
    'label' => 'Page type',
    'default' => $defaultType,
    'options' => $types,
])
