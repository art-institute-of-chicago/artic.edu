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

<x-twill::input
    name='tag'
    label='Tag'
    :maxlength='100'
/>
