@twillBlockTitle('Ranged Accordion')
@twillBlockIcon('text')

<x-twill::radios
    name='type'
    label='Type'
    default='true'
    :options="[
        [
            'value' => 'start',
            'label' => 'Start',
        ],
        [
            'value' => 'end',
            'label' => 'End',
        ]
    ]"
/>

    <x-twill::formConnectedFields
        field-name='type'
        field-values="start"
        :render-for-blocks='true'
    >
        <x-twill::input
            name='title'
            label='Title'
        />
    </x-twill::formConnectedFields>
