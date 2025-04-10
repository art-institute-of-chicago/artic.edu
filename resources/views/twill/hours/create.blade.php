<x-twill::input
    name='title'
    label='Title'
    :required='true'
/>

<x-twill::select
    name='type'
    label='Type'
    :unpack='true'
    :options='$types'
/>

@if(!isset($item))
    <x-twill::input
        name='url'
        label='URL'
        note='e.g., /visit'
    />

    <x-twill::date-picker
        name='valid_from'
        label='Valid From'
        :withTime='false'
        :required='true'
    />

    <x-twill::date-picker
        name='valid_through'
        label='Valid Through'
        :withTime='false'
        :required='false'
    />
@endif
