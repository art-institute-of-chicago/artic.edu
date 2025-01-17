@twillBlockTitle('Tombstone')
@twillBlockIcon('text')

<x-twill::input
    name='heading'
    label='Heading'
    default='Cat. '
/>

@formField('wysiwyg', [
    'name' => 'text',
    'label' => 'Text',
    'placeholder' => 'Text',
    'toolbarOptions' => [
        'bold', 'italic'
    ],
])
