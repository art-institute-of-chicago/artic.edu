@twillBlockTitle('Gallery')
@twillBlockIcon('image')

<p style="color: red">This block is deprecated. Its content will be migrated in a future release. Please use "Gallery (new)" for new content.</p>

@include('admin.partials.gallery-shared')

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 60
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'maxlength' => 500,
    'note' => 'Will be hidden if title is empty',
])

@formField('repeater', ['type' => 'gallery_item'])
