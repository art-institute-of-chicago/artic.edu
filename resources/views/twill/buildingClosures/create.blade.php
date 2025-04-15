@if(!isset($item))
    <x-twill::select
        name='"type"'
        label='"Type"'
        placeholder='Select a type'
        :options='$typesList'
        :required='true'
    />

    <x-twill::date-picker
        name='date_start'
        label='Start date'
        :withTime='false'
        :required='true'
    />

    <x-twill::date-picker
        name='date_end'
        label='End date'
        :withTime='false'
        :required='true'
    />

    <p>For a 1 day closure, use the same start and end date.</p>
@endif
