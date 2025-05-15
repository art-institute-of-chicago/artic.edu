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
    :translated='true'
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :toolbar-options="[ 'italic', 'link' ]"
    :translated='true'
/>

<x-twill::medias
    name='image'
    label='Image'
    :max='1'
    :translated='true'
/>
