@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'note' => 'Must be defined in lowercase',
])

@if (!isset($item))
    @formField('input', [
        'name' => 'destination',
        'label' => 'Destination',
        'required' => true,
    ])
@endif
