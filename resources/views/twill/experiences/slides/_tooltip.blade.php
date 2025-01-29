<x-twill::formConnectedFields
    field-name='module_type'
    field-values="tooltip"
>
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
    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="standard"
    >
        <x-twill::repeater
            type="tooltip_experience_image"
        />
        <component
        v-bind:is="`a17-block-tooltip`"
        :name="`tooltip`"
        :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}"></component>
    </x-twill::formConnectedFields>
</x-twill::formConnectedFields>
