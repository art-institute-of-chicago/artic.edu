@include('admin.partials.create')

@formField('select', [
    'name' => 'type',
    'label' => 'Page type',
    'default' => 11,
    'inline' => true,
    'options' => $typesOptions,
])
