@twillBlockTitle('Quote')
@twillBlockIcon('text')

<x-twill::input
    name='quote'
    type='textarea'
    label='Quote text'
    :rows='4'
    :translated='true'
/>

<x-twill::wysiwyg
    name='attribution'
    label='Attribution'
    :toolbar-options="[ 'italic' ]"
    :translated='true'
/>
