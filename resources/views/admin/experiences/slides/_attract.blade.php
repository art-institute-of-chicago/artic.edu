@if($item->module_type === 'attract')
    @formField('wysiwyg', [
        'name' => 'attract_title',
        'label' => 'Headline',
        'maxlength' => 500,
    ])

    @formField('wysiwyg', [
        'name' => 'attract_subhead',
        'label' => 'Subhead',
        'maxlength' => 500,
    ])

    @formField('repeater', ['type' => 'attract_experience_image'])
@endif