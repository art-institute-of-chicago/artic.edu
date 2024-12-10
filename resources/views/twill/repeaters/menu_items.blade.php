@twillRepeaterTitle('Menu Item')
@twillRepeaterTrigger('Add Menu Item')
@twillRepeaterComponent('a17-block-menu_item')
@twillRepeaterMax('10')

@formField('input', [
    'name' => 'label',
    'label' => 'Label',
    'maxlength' => 20
])

@formField('input', [
    'name' => 'link',
    'label' => 'Link'
])
