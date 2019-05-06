@if($item->module_type === 'attract')

@formField('wysiwyg', [
    'name' => 'headline',
    'label' => 'Headline',
    'maxlength' => 500,
])

@formField('wysiwyg', [
    'name' => 'attract_subhead',
    'label' => 'Subhead',
    'maxlength' => 500,
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'asset_type',
    'fieldValues' => 'standard',
    'keepAlive' => true,
])
    @formField('repeater', ['type' => 'attract_experience_image'])
@endcomponent
@endif