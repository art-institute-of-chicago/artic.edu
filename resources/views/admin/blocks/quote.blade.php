@twillBlockTitle('Quote')
@twillBlockIcon('text')
@twillBlockComponent('a17-block-quote')

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
