@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'testing', 'label' => 'Testing'],
    ]
])

@section('contentFields')

    <x-twill::input
        name='id'
        label='Email Series ID'
        disabled='true'
    />

    <x-twill::input
        name='timing_message'
        label='Timing information'
        note='Will be appended in parentheses to the label'
    />

    <hr>

    <x-twill::checkbox
        name='show_affiliate'
        label='Show "Include affiliate-specific copy" option'
    />

    <x-twill::checkbox
        name='show_member'
        label='Show "Include member-specific copy" option'
    />

    <x-twill::checkbox
        name='show_luminary'
        label='Show "Include luminary-specific copy" option'
    />

    <x-twill::checkbox
        name='show_nonmember'
        label='Show "Include nonmember-specific copy" option'
    />

    <p>The phrase "(overrides default copy)" will be appended to each option in the event form.</p>

    <p>If only one option is shown, we will label the option "Override default copy" for simplicity.</p>

    <hr>

    <x-twill::wysiwyg
        name='alert_message'
        label='General alert message'
        note='Will be displayed before the copy selection options'
        :toolbar-options="[ 'bold', 'italic', 'link' ]"
    />

@stop


@section('fieldsets')

    <x-twill::formFieldset id="testing" title="Testing">

        <x-twill::checkbox
            name='show_affiliate_test'
            label='Show "Send affiliate test" option'
        />

        <x-twill::checkbox
            name='show_member_test'
            label='Show "Send member test" option'
        />

        <x-twill::checkbox
            name='show_luminary_test'
            label='Show "Send luminary test" option'
        />

        <x-twill::checkbox
            name='show_nonmember_test'
            label='Show "Send nonmember test" option'
        />

        <p>If only one option is selected here, we won't show it on the event form. We will assume that if the email series is selected for testing, then it should be sent only to the member group selected here.</p>

    </x-twill::formFieldset>

@endsection
