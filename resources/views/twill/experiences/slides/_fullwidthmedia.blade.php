<x-twill::formConnectedFields
    field-name='module_type'
    field-values="fullwidthmedia"
    :keep-alive='true'
>
    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="standard"
        :keep-alive='true'
    >
        <x-twill::formConnectedFields
            field-name='fullwidthmedia_standard_media_type'
            field-values='type_image'
            :keep-alive='true'
        >
            <x-twill::repeater
                type="fullwidthmedia_experience_image"
            />
        </x-twill::formConnectedFields>
    </x-twill::formConnectedFields>
    <x-twill::formConnectedFields
        field-name='fullwidthmedia_standard_media_type'
        field-values="type_image"
        :keep-alive='true'
    >
        <x-twill::formConnectedFields
            field-name='asset_type'
            field-values='3dModel'
            :is-equal='false'
        >
            <x-twill::repeater
                type="experience_modal"
            />
        </x-twill::formConnectedFields>
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="3dModel"
        :keep-alive='true'
    >
        <br />
        <x-twill::formFieldset title="3D Object" id="3dModel">
            <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="true" :browser="false" :cc0="false" />
        </x-twill::formFieldset>
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="3dModel"
        :is-equal='false'
    >
    </x-twill::formConnectedFields>
    <x-twill::checkbox
        name='fullwidth_inset'
        label='Inset'
    />
</x-twill::formConnectedFields>
