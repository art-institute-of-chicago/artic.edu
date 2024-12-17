@twillBlockTitle('Quote')
@twillBlockIcon('text')

@formField('input', [
    'name' => 'quote',
    'type' => 'textarea',
    'label' => 'Quote text',
    'rows' => 4
])

@formField('wysiwyg', [
    'name' => 'attribution',
    'label' => 'Attribution',
    'toolbarOptions' => [
        'italic'
    ],
])
