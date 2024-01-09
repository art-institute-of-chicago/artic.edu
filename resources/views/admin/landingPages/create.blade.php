@include('admin.partials.create')

@formField('select', [
    'name' => 'type_id',
    'label' => 'Page type',
    'default' => $defaultType,
    'options' => $types,
])
