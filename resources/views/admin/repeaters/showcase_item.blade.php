@twillRepeaterTitle('Showcase Item')
@twillRepeaterMax('4')

@formField('select', [
    'name' => 'media_type',
    'label' => 'Media Type',
    'required' => true,
    'unpack' => true,
    'options' => collect(['image' => 'Image', 'video' => 'Video']),
])

@formConnectedFields([
    'fieldName' => 'media_type',
    'fieldValues' => 'image',
    'renderForBlocks' => true,
])
    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1,
        'withVideoUrl' => false,
        'required' => true,
    ])
@endcomponent

@formConnectedFields([
    'fieldName' => 'media_type',
    'fieldValues' => 'video',
    'renderForBlocks' => true,
])
    @formField('files', [
        'name' => 'video',
        'label' => 'Video',
        'max' => 1,
        'required' => true,
    ])
@endcomponent

@formField('input', [
    'name' => 'tag',
    'label' => 'Tag',
    'maxlength' => 100,
])

@formField('wysiwyg', [
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 100,
    'required' => true,
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'required' => true,
    'toolbarOptions' => [
        'bold',
        'italic',
        'underline',
        'link',
        ['color' => ['#333', '#FFF', '#DE2F1B']],
        ['list' => 'bullet'],
        ['list' => 'ordered'],
    ],
])

@formField('input', [
    'name' => 'link_label',
    'label' => 'Link Label'
])

@formField('input', [
    'name' => 'link_url',
    'label' => 'Link Url'
])
