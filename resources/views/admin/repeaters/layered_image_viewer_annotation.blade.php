@twillRepeaterTitle('Annotation')
@twillRepeaterTrigger('Add annotation')
@twillRepeaterComponent('a17-block-layered_image_viewer_annotation')
@twillRepeaterMax('10')


@formField('medias', [
    'name' => 'image',
    'label' => 'Annotation',
    'max' => 1
])

@formField('input', [
    'name' => 'label',
    'label' => 'Label',
    'note' => 'Displayed at bottom of annotation',
    'maxlength' => 40,
])
