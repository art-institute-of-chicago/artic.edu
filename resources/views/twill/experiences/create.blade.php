@include('admin.partials.create')

@formField('select', [
    'name' => 'interactive_feature_id',
    'label' => 'Grouping',
    'placeholder' => 'Select an grouping',
    'options' => $groupingsList,
])
