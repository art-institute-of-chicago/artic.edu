@twillBlockTitle('Quote')
@twillBlockIcon('text')

<x-twill::input
    name='quote'
    type='textarea'
    label='Quote text'
    :rows='4'
/>

@formField('wysiwyg', [
    'name' => 'attribution',
    'label' => 'Attribution',
    'toolbarOptions' => [
        'italic'
    ],
])
