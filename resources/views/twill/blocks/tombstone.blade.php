@twillBlockTitle('Tombstone')
@twillBlockIcon('text')

<x-twill::input
    name='heading'
    label='Heading'
    default='Cat. '
/>

<x-twill::wysiwyg
    name='text'
    label='Text'
    placeholder='Text'
    :toolbar-options="[ 'bold', 'italic' ]"
/>
