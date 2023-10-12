@twillBlockTitle('Showcase')
@twillBlockIcon('image')

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1,
    'withVideoUrl' => false,
    'required' => true,
])

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
])

@formField('input', [
    'name' => 'link_label',
    'label' => 'Link label'
])

@formField('input', [
    'name' => 'link_url',
    'label' => 'Link Url'
])
