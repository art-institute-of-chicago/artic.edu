<x-twill::formConnectedFields
    field-name='module_type'
    field-values="split"
    :keep-alive='true'
>
    <div style="display: none" id="headline">
        <x-twill::input
            name='headline'
            label='Headline'
        />
    </div>

    <x-twill::wysiwyg
        name='split_primary_copy'
        label='Primary Copy'
    />

    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="standard"
        :keep-alive='true'
    >
        <x-twill::formConnectedFields
            field-name='split_standard_media_type'
            field-values="type_image"
            :keep-alive='true'
        >
            <x-twill::repeater
                type="slide_primary_experience_image"
            />
        </x-twill::formConnectedFields>
    </x-twill::formConnectedFields>

    <x-twill::radios
        name='image_side'
        label='Primary Copy Side'
        default='left'
        :inline='true'
        // The value and label not matched because on FE, it's controlling the image's side, but client want to rename the label to primary copy side
        :options="[
            [
                'value' => 'right',
                'label' => 'Left'
            ],
            [
                'value' => 'left',
                'label' => 'Right'
            ]
        ]"
    />

    <div style="display: none" id="secondary_image">
        <x-twill::repeater
            type="slide_secondary_experience_image"
        />
    </div>

    <div style="display: none" id="primary_modal">
        <x-twill::repeater
            type="primary_experience_modal"
        />
    </div>
    <div style="display: none" id="secondary_modal">
        <x-twill::repeater
            type="secondary_experience_modal"
        />
    </div>
</x-twill::formConnectedFields>
