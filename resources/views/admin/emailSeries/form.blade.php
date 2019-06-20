@extends('twill::layouts.form')

@section('contentFields')

    @formField('input', [
        'name' => 'id',
        'label' => 'Email Series ID',
        'disabled' => true
    ])

    <hr>

    @formField('checkbox', [
        'name' => 'show_non_member',
        'label' => 'Show "Send to Non-Members" option'
    ])

    @formField('checkbox', [
        'name' => 'show_member',
        'label' => 'Show "Send to Members" option'
    ])

    @formField('checkbox', [
        'name' => 'show_sustaining_fellow',
        'label' => 'Show "Send to Sustaining Fellows" option'
    ])

    @formField('checkbox', [
        'name' => 'show_affiliate_member',
        'label' => 'Show "Send to Affiliate Members" option'
    ])

    <hr>

    @formField('checkbox', [
        'name' => 'use_short_description',
        'label' => 'Use short description as default copy',
    ])

    <hr>

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'use_short_description',
        'renderForBlocks' => false,
        'fieldValues' => true,
    ])
        <p>Uncheck "Use short description" to set default fields.</p>
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'use_short_description',
        'renderForBlocks' => false,
        'fieldValues' => false,
    ])
        @formField('wysiwyg', [
            'name' => 'non_member_copy',
            'label' => 'Default "Non-Member" copy',
            'toolbarOptions' => [
                'bold', 'italic', 'link'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'member_copy',
            'label' => 'Default "Member" copy',
            'toolbarOptions' => [
                'bold', 'italic', 'link'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'sustaining_fellow_copy',
            'label' => 'Default "Sustaining Fellows" copy',
            'toolbarOptions' => [
                'bold', 'italic', 'link'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'affiliate_member_copy',
            'label' => 'Default "Affiliate Group" copy',
            'toolbarOptions' => [
                'bold', 'italic', 'link'
            ],
        ])
    @endcomponent

@stop
