@include('twill.partials.create')

<x-twill::wysiwyg
    name='description'
    label='Description'
    type='textarea'
    :maxlength='1000'
    :rows='6'
    :toolbar-options="[ 'bold', 'italic', 'link' ]"
/>
