@twillBlockTitle('Grid')
@twillBlockIcon('image')

<x-twill::wysiwyg
    name='heading'
    label='Heading'
    :maxlength='60'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::input
    name='grid_link_label'
    label='Link Label'
    note='Displayed at top-right of title bar'
    :maxlength='60'
/>

<x-twill::input
    name='grid_link_href'
    label='Link URL'
    :maxlength='60'
/>

<x-twill::select
    name='variation'
    label='Variation'
    default="3-wide"
    :options="[
        [
            'value' => '3-wide',
            'label' => 'Default (3 wide)',
        ],
        [
            'value' => '4-wide',
            'label' => '4 wide',
        ],
    ]"
/>

<x-twill::repeater
    type="grid_item"
/>
