@include('admin.partials.create')

@formField('input', [
    'name' => 'issue_number',
    'label' => 'Issue number',
    'required' => true,
    'type' => 'number',
    'note' => 'Required',
])
