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

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'inline_credits',
        'fieldValues' => 'on',
        'keepAlive' => true,
        'renderForBlocks' => true
])
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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'credits_input',
        'fieldValues' => 'datahub',
        'renderForBlocks' => true,
        'keepAlive' => true,
    ])
        <x-twill::input
            name='object_id'
            label='Object ID'
            note='To see fields update: 1. Enter object ID 2. Click Update button 3. Refresh browser'
            :maxlength='150'
        />
    @endcomponent

    <x-twill::wysiwyg
        type='textarea'
        name='image_credits'
        label='Image credits'
        :toolbar-options="[ 'italic', 'bold' ]"
    />

@endcomponent
