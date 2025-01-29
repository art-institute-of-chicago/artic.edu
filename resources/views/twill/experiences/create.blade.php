@include('twill.partials.create')

@php
    $groupingsList = App\Models\InteractiveFeature::all()->map(function (App\Models\InteractiveFeature $item) {
        return ['value' => $item->id, 'label' => $item->title];
    })->toArray();
@endphp

<x-twill::select
    name='interactive_feature_id'
    label='Grouping'
    placeholder='Select an grouping'
    :options="$groupingsList"
/>
