@twillBlockTitle('Mirador Modal')
@twillBlockIcon('image')

<x-twill::medias
    name='image'
    label='Mirador Image'
    :max='1'
/>

<x-twill::input
    type='number'
    name='objectId'
    label='Object ID'
    note='Enter object ID to obtain manifest dynamically.'
/>

<x-twill::files
    name='upload_manifest_file'
    label='Alternative manifest file'
    note='Upload a .json file'
/>

<x-twill::radios
    name='default_view'
    label='Default View'
    default='single'
    :inline='true'
    :options="[
        [
            'value' => 'single',
            'label' => 'Single'
        ],
        [
            'value' => 'book',
            'label' => 'Book'
        ]
    ]"
/>

<x-twill::wysiwyg
    name='caption_title'
    label='Caption title'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='caption'
    label='Caption'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
/>
