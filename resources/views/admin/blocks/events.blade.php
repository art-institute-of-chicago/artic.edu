@php
$audiences = [];
$types = [];

foreach (\App\Models\Event::$eventAudiences as $key => $audience) {
    array_push($audiences, [
        'value'  => $key,
        'label' => $audience,
    ]);
}

foreach (\App\Models\Event::$eventTypes as $key => $type) {
    array_push($types, [
        'value'  => $key,
        'label' => $type,
    ]);
}
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
