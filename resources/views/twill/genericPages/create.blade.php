@include('twill.partials.create')

@if (!isset($item))
    <x-twill::select
        name='parent_id'
        label='Parent Page'
        :options='$pages'
    />
@endif
