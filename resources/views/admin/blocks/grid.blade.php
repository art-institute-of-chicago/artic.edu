@twillBlockTitle('Grid')
@twillBlockIcon('image')

@formField('wysiwyg', [
    'name' => 'heading',
    'label' => 'Heading',
    'maxlength' => 60,
    'toolbarOptions' => [
        'italic',
    ],
])

@formField('input', [
    'name' => 'grid_link_label',
    'label' => 'Link Label',
    'maxlength' => 60,
    'note' => 'Displayed at top-right of title bar',
])

@formField('input', [
    'name' => 'grid_link_href',
    'label' => 'Link URL',
    'maxlength' => 60,
])

@formField('repeater', ['type' => 'grid_item'])
