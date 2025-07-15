<x-twill::select
    name='variation'
    label='Variation'
    :options="[
        [
            'value' => 'default',
            'label' => 'Default',
        ],
    ]"
/>

<x-twill::formConnectedFields
    field-name='variation'
    field-values='default'
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::input
    name='tag'
    label='Tag'
    :maxlength='100'
    />

    <x-twill::wysiwyg
        name='callout'
        label='Callout'
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='button_label'
                label='Button Label'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::input
                name='button_url'
                label='Button Url'
            />
        </x-slot:right>
    </x-twill::formColumns>

</x-twill::formConnectedFields>
