@formField('select', [
    'name' => 'type',
    'label' => 'Type of rule',
    'options' => \App\Models\DateRule::getRuleTypes(),
    'default' => 0
])

@component('cms-toolkit::partials.form.utils._columns')
    @slot('left')
        @formField('date_picker', [
            'name' => 'start_date',
            'label' => 'Start Date',
            'withTime' => false
        ])
    @endslot
    @slot('right')
        @formField('date_picker', [
            'name' => 'end_date',
            'label' => 'Ends',
            'withTime' => false
        ])

        @formField('input', [
            'name' => 'ocurrencies',
            'label' => 'Or stop after the following amount of ocurrencies:',
            'type' => 'number',
            'placeholder' => '1, 2, 3.... etc',
        ])
    @endslot
@endcomponent


@component('cms-toolkit::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'every',
            'label' => 'Repeat every',
            'type' => 'number',
            'placeholder' => '1, 2, 3.... etc'
        ])
    @endslot
    @slot('right')
        @formField('select', [
            'name' => 'recurring_type',
            'label' => 'Days/Week/Month',
            'options' => \App\Models\DateRule::getRecurringTypes(),
            'default' => 0
        ])
    @endslot
@endcomponent

@component('cms-toolkit::partials.form.utils._collapsed_fields')
    @slot('label', 'Edit weekly/monthly options')


    @component('cms-toolkit::partials.form.utils._inline_checkboxes')
        @slot('label', 'If repeated weekly, which days?')

        @formField('checkbox', [
            'name' => 'monday',
            'label' => 'Monday',
        ])
        @formField('checkbox', [
            'name' => 'tuesday',
            'label' => 'Tuesday',
        ])
        @formField('checkbox', [
            'name' => 'wednesday',
            'label' => 'Wednesday',
        ])
        @formField('checkbox', [
            'name' => 'thursday',
            'label' => 'Thursday',
        ])
        @formField('checkbox', [
            'name' => 'friday',
            'label' => 'Friday',
        ])
        @formField('checkbox', [
            'name' => 'saturday',
            'label' => 'Saturday',
        ])
        @formField('checkbox', [
            'name' => 'sunday',
            'label' => 'Sunday',
        ])
    @endcomponent

    @formField('select', [
        'name' => 'monthly_repeat_pattern',
        'label' => 'If repeated monthly, select a pattern',
        'options' => \App\Models\DateRule::getMonthlyRepeat(),
        'default' => 0
    ])
@endcomponent
