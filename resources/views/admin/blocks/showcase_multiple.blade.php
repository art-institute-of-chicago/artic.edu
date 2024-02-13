@twillBlockTitle('Showcase Multiple')
@twillBlockIcon('image')

@formField('input', [
    'name' => 'id',
    'label' => 'Block ID',
    'note' => 'Utilized to link to the block',
])

@formField('input', [
    'name' => 'heading',
    'label' => 'Heading',
])

@formField('input', [
    'name' => 'intro',
    'label' => 'Intro',
])

@formField('repeater', ['type' => 'showcase_item'])
