<x-twill::medias
    name='experience_image'
    label='Image'
/>

@yield('caption')

<x-twill::radios
    name='inline_credits'
    label='Inline Credits'
    default='off'
    :inline='true'
    :options="[
        [
            'value' => 'on',
            'label' => 'On'
        ],
        [
            'value' => 'off',
            'label' => 'Off'
        ]
    ]"
/>

<x-twill::formConnectedFields
        field-name='inline_credits'
        field-values="on"
        :keep-alive='true'
        :render-for-blocks='true'
>
    <x-twill::radios
        name='credits_input'
        label='Credits Input'
        default='datahub'
        :inline='true'
        :maxlength='150'
        :options="[
            [
                'value' => 'datahub',
                'label' => 'Datahub'
            ],
            [
                'value' => 'manual',
                'label' => 'Manual'
            ]
        ]"
    />

    <x-twill::formConnectedFields
        field-name='credits_input'
        field-values="datahub"
        :render-for-blocks='true'
        :keep-alive='true'
    >
        <x-twill::input
            name='object_id'
            label='Object ID'
            note='To see fields update: 1. Enter object ID 2. Click Update button 3. Refresh browser'
            :maxlength='150'
        />
    </x-twill::formConnectedFields>

    <x-twill::wysiwyg
        type='textarea'
        name='image_credits'
        label='Image credits'
        :toolbar-options="[ 'italic', 'bold' ]"
    />

</x-twill::formConnectedFields>
