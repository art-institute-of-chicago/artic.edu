@twillRepeaterTitle('Image')
@twillRepeaterTrigger('Add image')


@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1
])

@formField('checkbox', [
    'name' => 'is_zoomable',
    'label' => 'Make this image modal zoomable',
])

