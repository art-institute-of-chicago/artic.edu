@formField('input', [
    'name' => 'issue_number',
    'label' => 'Issue number',
    'required' => true,
    'type' => 'number',
    'maxlength' => 3,
    'note' => 'Required',
])

@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink'
])

@if ($permalink ?? true)
    @formField('input', [
        'name' => 'slug',
        'label' => 'Permalink',
        'translated' => true,
        'ref' => 'permalink',
        'prefix' => $permalinkPrefix ?? ''
    ])
@endif
