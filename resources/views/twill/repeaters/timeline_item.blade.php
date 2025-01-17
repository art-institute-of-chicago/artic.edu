@twillRepeaterTitle('Timeline Item')
@twillRepeaterTrigger('Add Timeline')
@twillRepeaterComponent('a17-block-timeline_item')
@twillRepeaterMax('10')

@formField('input', [
    'name' => 'time',
    'label' => 'Time'
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title'
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'toolbarOptions' => [
        'italic', 'link'
    ],
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])
