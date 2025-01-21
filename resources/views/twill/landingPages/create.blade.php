@include('twill.partials.create')

<x-twill::select
    name='type_id'
    label='Page type'
    default='$defaultType'
    :options='$types'
/>
