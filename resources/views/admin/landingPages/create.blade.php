@include('admin.partials.create')

@formField('select', [
    'name' => 'type',
    'label' => 'Page type',
    'default' => array_search('Custom', $types),
    'inline' => true,
    'options' => $typesOptions,
])
