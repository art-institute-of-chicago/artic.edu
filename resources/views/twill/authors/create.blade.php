@include('admin.partials.create')

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'maxlength' => 1000,
    'type' => 'textarea',
    'rows' => 6,
    'toolbarOptions' => [
        'bold', 'italic', 'link'
    ],
])
