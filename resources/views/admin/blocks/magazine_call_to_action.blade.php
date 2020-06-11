@formField('radios', [
    'name' => 'color',
    'label' => 'Color',
    'default' => 'default',
    'inline' => true,
    'options' => [
        [
            'value' => 'default',
            'label' => 'Default'
        ],
        [
            'value' => 'alternate',
            'label' => 'Alternate'
        ],
    ]
])

@formField('input', [
    'name' => 'tag',
    'label' => 'Tag',
    'note' => 'Small text, e.g. "Exhibition"'
])

@formField('wysiwyg', [
    'name' => 'title',
    'label' => 'Title',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('input', [
    'name' => 'link_text',
    'label' => 'Link text'
])

@formField('input', [
    'name' => 'link_url',
    'label' => 'Link URL'
])
