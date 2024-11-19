@twillRepeaterTitle('Grid Item')
@twillRepeaterTrigger('Add Grid Item')
@twillRepeaterComponent('a17-block-grid_item')
@twillRepeaterMax('48')

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])

@formField('wysiwyg', [
    'name' => 'title',
    'label' => 'Title',
    'toolbarOptions' => [
        'italic',
    ],
])

@formField('input', [
    'name' => 'tag',
    'label' => 'Tag',
    'note' => 'Displayed in smaller font above title',
])

@formField('wysiwyg', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'toolbarOptions' => [
        'italic',
    ],
])

@component('twill::partials.form.utils._columns')
@slot('left')

@formField('input', [
    'name' => 'label',
    'label' => 'Label',
])
@endslot

@slot('right')
@formField('radios', [
    'name' => 'label_position',
    'label' => 'Label position',
    'note' => '',
    'inline' => true,
    'options' => [
        [
            'value' => 'overlay',
            'label' => 'Bottom of image'
        ],
        [
            'value' => 'description',
            'label' => 'Below description'
        ]
    ]
])
@endslot
@endcomponent

@formField('input', [
    'name' => 'url',
    'label' => 'URL'
])
