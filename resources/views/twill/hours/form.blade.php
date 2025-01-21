@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
    />

    <x-twill::select
        name='type'
        label='Type'
        :unpack='true'
        :options='$types'
    />

    <x-twill::input
        name='url'
        label='URL'
        note='e.g., /visit'
    />

    <x-twill::date-picker
        name='valid_from'
        label='Valid From'
        withTime='false'
        :required='true'
    />

    <x-twill::date-picker
        name='valid_through'
        label='Valid Through'
        withTime='false'
        :required='false'
    />
@stop

@section('fieldsets')

<a17-fieldset id="monday_hours" title="Monday">
    <x-twill::checkbox
        name='monday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'monday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='monday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='monday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='monday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='monday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="tuesday_hours" title="Tuesday">
    <x-twill::checkbox
        name='tuesday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'tuesday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='tuesday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='tuesday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='tuesday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='tuesday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="wednesday_hours" title="Wednesday">
    <x-twill::checkbox
        name='wednesday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'wednesday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='wednesday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='wednesday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='wednesday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='wednesday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="thursday_hours" title="Thursday">
    <x-twill::checkbox
        name='thursday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'thursday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='thursday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='thursday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='thursday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='thursday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="friday_hours" title="Friday">
    <x-twill::checkbox
        name='friday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'friday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='friday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='friday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='friday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='friday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="saturday_hours" title="Saturday">
    <x-twill::checkbox
        name='saturday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'saturday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='saturday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='saturday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='saturday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='saturday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="sunday_hours" title="Sunday">
    <x-twill::checkbox
        name='sunday_is_closed'
        label='Is closed?'
    />

    @formConnectedFields([
        'fieldName' => 'sunday_is_closed',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])
        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::select
                name='sunday_member_open'
                label='Member open'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='sunday_public_open'
                label='Public open'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @slot('right')
            <x-twill::select
                name='sunday_member_close'
                label='Member close'
                :options="DateHelpers::hoursSelectOptions()"
            />
            <x-twill::select
                name='sunday_public_close'
                label='Public close'
                :options="DateHelpers::hoursSelectOptions()"
            />
        @endslot
        @endcomponent
    @endformConnectedFields
</a17-fieldset>

<a17-fieldset id="additional" title="Additional content">
    <x-twill::input
        name='additional_text'
        label='Additional text'
        note='For the "See all hours" modal'
    />

    <x-twill::wysiwyg
        name='summary'
        label='Summary'
        note='Shown in the site-wide footer'
        :maxlength='255'
        :toolbar-options="[ ['header' => 4] ]"
    />
</a17-fieldset>

<a17-fieldset id="closures" title="Closures">
    @formField('repeater', [
        'type' => 'building_closures',
        'title' => 'Closures',
    ])
</a17-fieldset>

@stop
