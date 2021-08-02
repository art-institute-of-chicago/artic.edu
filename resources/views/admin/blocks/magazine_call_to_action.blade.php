@twillBlockTitle('Magazine Call to Action')
@twillBlockIcon('text')

@formField('radios', [
    'name' => 'theme',
    'label' => 'Theme',
    'default' => 'dark',
    'inline' => true,
    'options' => [
        [
            'value' => 'dark',
            'label' => 'Dark'
        ],
        [
            'value' => 'light',
            'label' => 'Light'
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
