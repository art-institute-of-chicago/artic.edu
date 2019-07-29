@extends('twill::layouts.form')

@section('contentFields')

    @formField('input', [
        'name' => 'id',
        'label' => 'Email Series ID',
        'disabled' => true
    ])

    @formField('input', [
        'name' => 'timing_message',
        'label' => 'Timing information',
        'note' => 'Will be appended in parentheses to the label'
    ])

    <hr>

    @formField('checkbox', [
        'name' => 'show_affiliate_member',
        'label' => 'Show "Include affiliate-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_member',
        'label' => 'Show "Include member-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_sustaining_fellow',
        'label' => 'Show "Include sustaining fellow-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_non_member',
        'label' => 'Show "Include nonmember-specific copy" option'
    ])

    <p>The phrase "(overrides default copy)" will be appended to each option in the event form.</p>

    <p>If only one option is shown, we will label the option "Override default copy" for simplicity.</p>

    <hr>

    @formField('wysiwyg', [
        'name' => 'alert_message',
        'label' => 'General alert message',
        'note' => 'Will be displayed before the copy selection options',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
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
            'name' => 'affiliate_member_copy',
            'label' => 'Default "Affiliate Group" copy',
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
            'name' => 'non_member_copy',
            'label' => 'Default "Nonmember" copy',
            'toolbarOptions' => [
                'bold', 'italic', 'link'
            ],
        ])
    @endcomponent

@stop
