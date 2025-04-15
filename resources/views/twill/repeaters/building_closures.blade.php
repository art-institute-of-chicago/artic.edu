@twillRepeaterTitle('Closures')
@twillRepeaterTrigger('Add Closure')
@twillRepeaterComponent('a17-block-building_closures')

@formField('date_picker', [
    'name' => 'date_start',
    'label' => 'Start Date',
    'withTime' => false,
    'required' => true
])

@formField('date_picker', [
    'name' => 'date_end',
    'label' => 'End Date',
    'withTime' => false,
    'required' => true
])

<p>For a 1 day closure, use the same start and end date.</p>

@formField('wysiwyg', [
    'name' => 'closure_copy',
    'label' => 'Closure Copy',
    'toolbarOptions' => [
        'italic', 'link'
    ],
    'maxlength' => 255
])
