@twillRepeaterTitle('Gallery Item')
@twillRepeaterTrigger('Add Image')
@twillRepeaterComponent('a17-block-gallery_item')

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1
])

<x-twill::wysiwyg
    name='captionTitle'
    label='Caption title'
    note='Max 80 characters'
    :maxlength='80'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='caption'
    label='Caption'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::input
    name='videoUrl'
    label='YouTube URL'
    note='Provide to show video in modal instead of image'
/>
