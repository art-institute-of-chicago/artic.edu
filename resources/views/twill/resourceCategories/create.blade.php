<x-twill::input
    name='name'
    label='Name'
    :required='true'
/>

<x-twill::radios
    name='type'
    label='Category Type'
    default='topic'
    :inline='true'
    :options="[
        [
            'value' => 'topic',
            'label' => 'Topic'
        ],
        [
            'value' => 'audience',
            'label' => 'Audience'
        ],
        [
            'value' => 'content',
            'label' => 'Content'
        ],
    ]"
/>
