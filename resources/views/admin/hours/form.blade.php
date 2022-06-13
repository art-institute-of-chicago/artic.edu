@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'url',
        'label' => 'URL',
        'note' => 'e.g., /visit'
    ])

    @formField('date_picker', [
        'name' => 'valid_from',
        'label' => 'Valid From',
        'withTime' => false,
        'required' => true
    ])

    @formField('date_picker', [
        'name' => 'valid_through',
        'label' => 'Valid Through',
        'withTime' => false,
        'required' => false
    ])
@stop

@section('fieldsets')

<a17-fieldset id="monday_hours" title="Monday">
    @formField('checkbox', [
        'name' => 'monday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'monday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'monday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'monday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'monday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'monday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="tuesday_hours" title="Tuesday">
    @formField('checkbox', [
        'name' => 'tuesday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'tuesday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'tuesday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'tuesday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'tuesday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'tuesday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="wednesday_hours" title="Wednesday">
    @formField('checkbox', [
        'name' => 'wednesday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'wednesday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'wednesday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'wednesday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'wednesday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'wednesday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="thursday_hours" title="Thursday">
    @formField('checkbox', [
        'name' => 'thursday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'thursday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'thursday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'thursday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'thursday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'thursday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="friday_hours" title="Friday">
    @formField('checkbox', [
        'name' => 'friday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'friday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'friday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'friday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'friday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'friday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="saturday_hours" title="Saturday">
    @formField('checkbox', [
        'name' => 'saturday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'saturday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'saturday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'saturday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'saturday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'saturday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="sunday_hours" title="Sunday">
    @formField('checkbox', [
        'name' => 'sunday_is_closed',
        'label' => 'Is closed?',
    ])

    @formConnectedFields([
        'fieldName' => 'sunday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('select', [
                'name' => 'sunday_member_open',
                'label' => 'Member open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'sunday_public_open',
                'label' => 'Public open',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @slot('right')
            @formField('select', [
                'name' => 'sunday_member_close',
                'label' => 'Member close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
            @formField('select', [
                'name' => 'sunday_public_close',
                'label' => 'Public close',
                'options' => DateHelpers::hoursSelectOptions()
            ])
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="additional" title="Additional content">
    @formField('input', [
        'name' => 'additional_text',
        'label' => 'Additional text',
        'note' => 'For the "See all hours" modal',
    ])

    @formField('wysiwyg', [
        'name' => 'summary',
        'label' => 'Summary',
        'maxlength' => 255,
        'note' => 'Shown in the site-wide footer',
        'toolbarOptions' => [
            ['header' => 4],
        ],
    ])
</a17-fieldset>

<a17-fieldset id="closures" title="Closures">
    @formField('repeater', [
        'type' => 'building_closures',
        'title' => 'Closures',
    ])
</a17-fieldset>

@stop
