@if($item->module_type === 'attract')
    <x-twill::wysiwyg
        name='attract_title'
        label='Headline'
        :maxlength='500'
    />

    <x-twill::wysiwyg
        name='attract_subhead'
        label='Subhead'
        :maxlength='500'
    />

    @formField('repeater', ['type' => 'attract_experience_image'])
@endif