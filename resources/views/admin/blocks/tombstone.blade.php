@twillBlockTitle('Tombstone')
@twillBlockIcon('text')

@formField('input', [
    'name' => 'heading',
    'label' => 'Heading',
    'default' => 'Cat. ',
])

@formField('wysiwyg', [
    'name' => 'text',
    'label' => 'Text',
    'placeholder' => 'Text',
    'toolbarOptions' => [
        'italic',
    ],
])
