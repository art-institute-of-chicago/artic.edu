@extends('twill::layouts.form')

@section('contentFields')
    @formField('select', [
        'name' => 'experience_type',
        'label' => 'Experience Type',
        'placeholder' => 'Select an experience type',
        'options' => [
            [
                'value' => 'label',
                'label' => 'Label'
            ],
            [
                'value' => 'explorer',
                'label' => 'Explorer'
            ],
        ]
    ])

    @formField('checkbox', [
        'name' => 'archived',
        'label' => 'Archived'
    ])
@stop
