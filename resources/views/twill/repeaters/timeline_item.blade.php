@twillRepeaterTitle('Timeline Item')
@twillRepeaterTrigger('Add Timeline')
@twillRepeaterComponent('a17-block-timeline_item')
@twillRepeaterMax('10')

<x-twill::input
    name='time'
    label='Time'
/>

<x-twill::input
    name='title'
    label='Title'
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :toolbar-options="[ 'italic', 'link' ]"
/>

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])
