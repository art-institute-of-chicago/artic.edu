@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink',
    'note' => 'Avoid HTML in this field. Use the "Title formatting (optional)" field for italics.',
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

@formField('select', [
    'name' => 'module_type',
    'required' => true,
    'label' => 'Module Type',
    'placeholder' => 'Select a type',
    'options' => [
        [
            'value' => 'split',
            'label' => 'Split'
        ],
        [
            'value' => 'interstitial',
            'label' => 'Interstitial'
        ],
        [
            'value' => 'tooltip',
            'label' => 'Tooltip'
        ],
        [
            'value' => 'full-width-media',
            'label' => 'Full-Width Media'
        ],
        [
            'value' => 'compare',
            'label' => 'Compare'
        ],
    ]
])
