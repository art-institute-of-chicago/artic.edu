@twillRepeaterTitle('Menu Item')
@twillRepeaterTrigger('Add Menu Item')
@twillRepeaterComponent('a17-block-menu_item')
@twillRepeaterMax('10')

<x-twill::input
    name='label'
    label='Label'
    :maxlength='20'
/>

<x-twill::input
    name='link'
    label='Link'
/>
