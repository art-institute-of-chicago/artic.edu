<x-twill::select
    name='variation'
    label='Variation'
    :options="[
        [
            'value' => 'default',
            'label' => 'Default',
        ],
        [
            'value' => '1e3f49',
            'label' => 'Dark Teal',
        ],
    ]"
/>

<x-twill::input
    name='tag'
    label='Tag'
    :maxlength='100'
/>
