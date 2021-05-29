@twillBlockTitle('Footnote')
@twillBlockIcon('text')
@twillBlockComponent('a17-block-footnote')

@formField('input', [
    'type' => 'textarea',
    'name' => 'text',
    'label' => 'Text',
    'rows' => 4
])

@formField('input', [
    'name' => 'anchor_link',
    'label' => 'Anchor Link'
])

@formField('input', [
    'name' => 'number',
    'label' => 'Footnote Number'
])
