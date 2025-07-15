<x-twill::select
    name='variation'
    label='Variation'
    :options="[
        [
            'value' => 'default',
            'label' => 'Default',
        ],
        [
            'value' => 'about-the-rlc',
            'label' => 'About the RLC',
        ],
        [
            'value' => 'rlc-secondary',
            'label' => 'RLC secondary (teal)',
        ],
    ]"
/>

<x-twill::input
    name='heading'
    label='Heading'
/>

<x-twill::input
    name='date'
    label='Date'
/>
