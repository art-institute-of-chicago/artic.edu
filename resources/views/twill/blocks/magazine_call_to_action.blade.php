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

<x-twill::input
    name='tag'
    label='Tag'
    note='Small text e.g. "Exhibition"'
/>

@formField('wysiwyg', [
    'name' => 'title',
    'label' => 'Title',
    'toolbarOptions' => [
        'italic'
    ],
])

<x-twill::input
    name='link_text'
    label='Link text'
/>

<x-twill::input
    name='link_url'
    label='Link URL'
/>
