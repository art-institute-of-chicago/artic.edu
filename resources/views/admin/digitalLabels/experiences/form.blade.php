@extends('twill::layouts.form')

@section('contentFields')
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

    @formField('repeater', ['type' => 'attract_experience_image'])

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

        @formField('repeater', ['type' => 'end_experience_image'])
    </a17-fieldset>

</a17-fieldset>
@stop