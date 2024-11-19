@twillBlockTitle('Link')
@twillBlockIcon('text')

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
     'maxlength' => 60
])

@formField('input', [
    'name' => 'link',
    'label' => 'Link'
])

@formField('files', [
    'name' => 'attachment',
    'label' => 'Attachment',
    'note' => 'Add one file'
])
