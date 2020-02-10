@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink'
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'maxlength' => 1000,
    'type' => 'textarea',
    'rows' => 6,
    'toolbarOptions' => [
        'bold', 'italic', 'link'
    ],
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
