@twillBlockTitle('Quote')
@twillBlockIcon('text')

<x-twill::input
    name='quote'
    type='textarea'
    label='Quote text'
    :rows='4'
/>

<x-twill::wysiwyg
    name='attribution'
    label='Attribution'
    :toolbar-options="[ 'italic' ]"
/>
