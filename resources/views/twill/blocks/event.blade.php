@twillBlockTitle('Event')
@twillBlockIcon('text')

@php
$programs = app(\App\Repositories\EventProgramRepository::class)->listAll('name')->sort();
@endphp

<x-twill::browser
    name='events'
    label='Event'
    route-prefix='exhibitionsEvents'
    module-name='events'
/>

<x-twill::checkbox
    name='display_upcoming'
    label='Display upcoming event'
    note='When the selected event has passed, display an upcoming event for the given program(s)'
/>

<x-twill::formConnectedFields
    field-name='display_upcoming'
    :field-values='true'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::multi-select
        name='programs'
        label='Program(s)'
        :options='$programs'
    />
</x-twill::formConnectedFields>
