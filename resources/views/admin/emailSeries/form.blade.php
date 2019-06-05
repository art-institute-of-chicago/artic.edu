@extends('twill::layouts.form')

@section('contentFields')
    @formField('checkbox', [
        'name' => 'show_affiliate_member',
        'label' => 'Show "Send to Affiliate Members" option'
    ])

    @formField('wysiwyg', [
        'name' => 'affiliate_member_copy',
        'label' => 'Default "Affiliate Member" copy',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
    ])

    @formField('checkbox', [
        'name' => 'show_member',
        'label' => 'Show "Send to Members" option'
    ])

    @formField('wysiwyg', [
        'name' => 'member_copy',
        'label' => 'Default "Members" copy',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
    ])

    @formField('checkbox', [
        'name' => 'show_sustaining_fellow',
        'label' => 'Show "Send to Sustaining Fellows" option'
    ])

    @formField('wysiwyg', [
        'name' => 'sustaining_fellow_copy',
        'label' => 'Default "Sustaining Fellows" copy',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
    ])

    @formField('checkbox', [
        'name' => 'show_non_member',
        'label' => 'Show "Send to non-members" option'
    ])

    @formField('wysiwyg', [
        'name' => 'non_member_copy',
        'label' => 'Default "non-member" copy',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
    ])
@stop
