
<x-twill::input
    name='title'
    label='Title'
/>
<x-twill::input
    name='youtube_id'
    label='YouTube ID'
/>
<x-twill::radios
    name='privacy'
    label='Privacy'
    default='public'
    :inline='true'
    :options="[
        [
            'value' => 'public',
            'label' => 'Public'
        ],
        [
            'value' => 'unlisted',
            'label' => 'Unlisted'
        ]
    ]"
/>
