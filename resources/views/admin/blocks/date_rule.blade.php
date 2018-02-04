@formField('select', [
    'name' => 'type',
    'label' => 'Type of rule',
    'options' => \App\Models\DateRule::getRuleTypes(),
    'default' => 0
])

@formField('date_picker', [
    'name' => 'start_date',
    'label' => 'Start Date',
])

@formField('date_picker', [
    'name' => 'end_date',
    'label' => 'Ends'
])

@formField('input', [
    'name' => 'ocurrencies',
    'label' => 'Or ends after these amount of ocurrencies:',
    'type' => 'number',
    'placeholder' => '1, 2, 3.... etc',
    'note' => 'Overwrites ending date'
])

@formField('input', [
    'name' => 'every',
    'label' => 'Repeat every',
    'type' => 'number',
    'placeholder' => '1, 2, 3.... etc'
])

@formField('select', [
    'name' => 'recurring_type',
    'label' => 'Days/Week/Month',
    'options' => \App\Models\DateRule::getRecurringTypes(),
    'default' => 0
])

<div>&nbsp;</div><div>&nbsp;</div>
<div>Weekly options:</div>

@formField('checkbox', [
    'name' => 'monday',
    'label' => 'Monday',
])
@formField('checkbox', [
    'name' => 'tuesday',
    'label' => 'tuesday',
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

<div>&nbsp;</div><div>&nbsp;</div>
<div>Monthly options:</div>

@formField('select', [
    'name' => 'monthly_repeat_pattern',
    'label' => 'Monthly repeat pattern',
    'options' => \App\Models\DateRule::getMonthlyRepeat(),
    'default' => 0
])
