@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'required' => true
])

@if(!isset($item))
    @formField('input', [
        'name' => 'copy',
        'required' => true,
        'label' => 'Sponsor copy',
    ])
@endif
