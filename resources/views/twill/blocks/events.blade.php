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

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])

@formField('multi_select', [
    'name' => 'audience',
    'label' => 'Audience',
    'options' => $audiences,
])

@formField('multi_select', [
    'name' => 'type',
    'label' => 'Type',
    'options' => $types,
])

@formField('multi_select', [
    'name' => 'program',
    'label' => 'Program',
    'options' => $programs,
])

@component('twill::partials.form.utils._columns')
@slot('left')
    @formField('date_picker', [
        'name' => 'date_start',
        'label' => 'Start date',
        'withTime' => false,
    ])
@endslot
@slot('right')
    @formField('date_picker', [
        'name' => 'date_end',
        'label' => 'End date',
        'withTime' => false,
    ])
@endslot
@endcomponent
