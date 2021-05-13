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
        ['header' => 2],
        ['header' => 3],
        'bold', 'italic', 'underline', 'link', 'list-unordered',
    ],
])
