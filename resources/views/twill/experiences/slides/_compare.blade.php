<x-twill::formConnectedFields
    field-name='module_type'
    field-values="compare"
    :keep-alive='true'
>
    <x-twill::wysiwyg
        name='compare_title'
        label='Primary Copy'
        :maxlength='500'
    />

    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="standard"
        :keep-alive='true'
    >
        <x-twill::repeater
            type='compare_experience_image_1'
        />
    </x-twill::formConnectedFields>
    <x-twill::repeater
        type='compare_experience_image_2'
    />

    <x-twill::repeater
        type="compare_experience_modal"
    />
</x-twill::formConnectedFields>
