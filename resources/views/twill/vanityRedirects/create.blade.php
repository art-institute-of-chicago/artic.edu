<x-twill::input
    name='{{ $titleFormKey ?? 'title' }}'
    label='{{ ucfirst($titleFormKey ?? 'title') }}'
    translated='{{ $translateTitle ?? false }}'
    note='Must be defined in lowercase'
    :required='true'
/>

@if (!isset($item))
    <x-twill::input
        name='destination'
        label='Destination'
        :required='true'
    />
@endif
