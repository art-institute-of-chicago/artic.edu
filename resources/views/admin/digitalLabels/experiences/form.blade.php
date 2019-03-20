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

@section('fieldsets')
<a17-fieldset title="Attract" id="attract" :open="true">
    @formField('input', [
        'name' => 'attract_title',
        'label' => 'Title'
    ])

    @formField('input', [
        'name' => 'youtube_url',
        'label' => 'Youtube URL'
    ])

    @formField('input', [
        'name' => 'attract_subhead',
        'label' => 'Subhead'
    ])
</a17-fieldset>

<a17-fieldset title="End" id="end" :open="true">
    @formField('input', [
        'name' => 'media_title',
        'label' => 'Media Title'
    ])

    <br />

    <a17-fieldset title="Credit" id="end" :open="true">
        @formField('input', [
            'name' => 'end_credit_subhead',
            'label' => 'Subhead'
        ])

        @formField('input', [
            'name' => 'end_credit_copy',
            'label' => 'Copy'
        ])
    </a17-fieldset>
</a17-fieldset>
@stop