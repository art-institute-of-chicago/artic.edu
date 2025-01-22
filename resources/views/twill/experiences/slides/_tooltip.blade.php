@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'tooltip',
])
    <x-twill::input
        name='object_title'
        label='Object Title'
        :maxlength='150'
    />
    <x-twill::wysiwyg
        name='caption'
        label='Caption'
        :maxlength='500'
    />
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
    ])
        <x-twill::repeater
            type="tooltip_experience_image"
        />
        <component
        v-bind:is="`a17-block-tooltip`"
        :name="`tooltip`"
        :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}"></component>
    @endcomponent
@endcomponent