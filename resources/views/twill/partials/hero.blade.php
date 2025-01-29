<x-twill::medias
    name='hero'
    label='Hero image'
    note='Minimum image width 3000px'
/>

<x-twill::medias
    name='mobile_hero'
    label='Mobile hero image'
    note='Minimum image width 3000px'
/>

<x-twill::wysiwyg
    type='textarea'
    name='hero_caption'
    label='Hero image caption'
    note='Usually used for copyright'
    :maxlength='255'
    :toolbar-options="[ 'italic', 'link' ]"
/>
