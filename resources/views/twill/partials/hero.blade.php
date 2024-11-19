@formField('medias', [
    'with_multiple' => false,
    'no_crop' => false,
    'label' => 'Hero image',
    'name' => 'hero',
    'note' => 'Minimum image width 3000px'
])

@formField('medias', [
    'with_multiple' => false,
    'no_crop' => false,
    'label' => 'Mobile hero image',
    'name' => 'mobile_hero',
    'note' => 'Minimum image width 3000px'
])

@formField('wysiwyg', [
    'type' => 'textarea',
    'name' => 'hero_caption',
    'label' => 'Hero image caption',
    'note' => 'Usually used for copyright',
    'maxlength' => 255,
    'toolbarOptions' => [
        'italic', 'link',
    ],
])
