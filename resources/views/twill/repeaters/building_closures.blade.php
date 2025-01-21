@twillRepeaterTitle('Closures')
@twillRepeaterTrigger('Add Closure')
@twillRepeaterComponent('a17-block-building_closures')

<x-twill::date-picker
    name='date_start'
    label='Start Date'
    withTime='false'
    :required='true'
/>

<x-twill::date-picker
    name='date_end'
    label='End Date'
    withTime='false'
    :required='true'
/>

<p>For a 1 day closure, use the same start and end date.</p>

<x-twill::wysiwyg
    name='closure_copy'
    label='Closure Copy'
    :maxlength="255"
    :toolbar-options="[ 'italic', 'link' ]
/>
