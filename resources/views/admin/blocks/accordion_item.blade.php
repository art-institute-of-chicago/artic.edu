@formField('input', [
    'name' => 'header',
    'label' => 'Header',
    'maxlength' => 60
])

@formField('wysiwyg', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'toolbarOptions' => [
        'bold', 'italic', 'underline', 'link', 'list-unordered',
    ],
])
