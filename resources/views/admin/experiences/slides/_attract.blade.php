@if($item->module_type === 'attract')
@formField('input', [
    'name' => 'headline',
    'label' => 'Headline'
])

@formField('input', [
    'name' => 'attract_subhead',
    'label' => 'Subhead'
])
@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'asset_type',
    'fieldValues' => 'standard',
    'keepAlive' => true,
])
    @formField('repeater', ['type' => 'attract_experience_image'])
@endcomponent
@endif