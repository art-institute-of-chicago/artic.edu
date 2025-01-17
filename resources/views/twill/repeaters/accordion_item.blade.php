@twillRepeaterTitle('Accordion Item')
@twillRepeaterTrigger('Add accordion item')
@twillRepeaterComponent('a17-block-accordion_item')
@twillRepeaterMax('20')

<x-twill::input
    name='header'
    label='Header'
    :maxlength='60'
/>

@formField('wysiwyg', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'toolbarOptions' => [
        ['header' => 4],
        'bold', 'italic', 'underline', 'link', 'list-unordered',
    ],
])
