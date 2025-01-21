@include('twill.partials.create')

<x-twill::select
    name='interactive_feature_id'
    label='Grouping'
    placeholder='Select an grouping'
    :options="$groupingsList"
/>
