@twillBlockTitle('Link')
@twillBlockIcon('text')

<x-twill::input
    name='title'
    label='Title'
    :maxlength='60'
/>

<x-twill::input
    name='link'
    label='Link'
/>

@formField('files', [
    'name' => 'attachment',
    'label' => 'Attachment',
    'note' => 'Add one file'
])
