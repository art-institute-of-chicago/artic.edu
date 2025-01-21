@twillBlockTitle('360 Modal')
@twillBlockIcon('image')

@formField('medias', [
    'name' => 'image',
    'label' => '360 Image',
    'max' => '1',
])

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

@formField('files', [
    'name' => 'image_sequence_file',
    'label' => '360 Zip',
    'note' => 'Upload a .zip file',
])
