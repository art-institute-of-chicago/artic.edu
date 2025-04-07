@php
  $noteHelperText = 'Must be defined in lowercase';
@endphp

@include('twill.partials.create')

@if (!isset($item))
    <x-twill::input
        name='destination'
        label='Destination'
        :required='true'
    />
@endif
