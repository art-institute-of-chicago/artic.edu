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
    name='tag'
    label='Tag'
    :maxlength='100'
/>

<x-twill::wysiwyg
    name='title'
    label='Title'
    :maxlength='100'
    :required='true'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :required='true'
/>

<x-twill::input
    name='date'
    label='Date'
/>
