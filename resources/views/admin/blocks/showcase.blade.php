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
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 100,
    'required' => true,
])

@formField('wysiwyg', [
    'name' => 'subtitle',
    'label' => 'Subtitle',
    'required' => true,
])

@formField('input', [
    'name' => 'tag',
    'label' => 'Tag',
    'maxlength' => 100,
    'required' => true,
])