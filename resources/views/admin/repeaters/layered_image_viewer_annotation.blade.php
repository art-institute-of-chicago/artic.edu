@twillRepeaterTitle('Annotation')
@twillRepeaterTrigger('Add annotation')


@formField('medias', [
    'name' => 'annotation',
    'label' => 'Annotation',
    'max' => 1
])

@formField('input', [
    'name' => 'label',
    'label' => 'Label',
    'note' => 'Displayed at bottom of image',
    'maxlength' => 40,
])
