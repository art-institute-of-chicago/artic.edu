@twillBlockTitle('Events')
@twillBlockIcon('text')

@php

use App\Repositories\EventProgramRepository;

$audiences = [];
$types = [];

foreach (\App\Models\Event::$eventAudiences as $key => $eventAudience) {
    array_push($audiences, [
        'value'  => $key,
        'label' => $eventAudience,
    ]);
}

foreach (\App\Models\Event::$eventTypes as $key => $eventType) {
    array_push($types, [
        'value'  => $key,
        'label' => $eventType,
    ]);
}

$programs = app(EventProgramRepository::class)->listAll('name');

@endphp

<x-twill::input
    name='title'
    label='Title'
/>

<x-twill::multi-select
    name='audience'
    label='Audience'
    :options='$audiences'
/>

<x-twill::multi-select
    name='type'
    label='Type'
    :options='$types'
/>

<x-twill::multi-select
    name='program'
    label='Program'
    :options='$programs'
/>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::date-picker
            name='date_start'
            label='Start date'
            :withTime='false'
        />
    </x-slot>
    <x-slot:right>
        <x-twill::date-picker
            name='date_end'
            label='End date'
            :withTime='false'
        />
    </x-slot>
</x-twill::formColumns>
