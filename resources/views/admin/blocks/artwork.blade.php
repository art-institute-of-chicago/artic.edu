@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;

    switch ($type) {
        case 'digitalPublications':
            $themes = ['default', 'Digital Publication'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Artwork')
@twillBlockIcon('image')

@formField('select', [
    'name' => 'theme',
    'label' => 'Theme',
    'default' => 'default',
    'disabled' => count($themes) === 1,
    'options' => collect($themes)->map(function($theme) {
        return [
            'value' => $theme,
            'label' => ucfirst($theme),
        ];
    })->toArray(),
])

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'default',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'size',
        'label' => 'Size',
        'placeholder' => 'Select size',
        'default' => 'm',
        'options' => [
            [
                'value' => 's',
                'label' => 'Small'
            ],
            [
                'value' => 'm',
                'label' => 'Medium'
            ],
            [
                'value' => 'l',
                'label' => 'Large'
            ]
        ]
    ])

    <p>Note: if the chosen artwork does not have rights to be viewed at a large size, it will display as size small</p>

    @formField('browser', [
        'routePrefix' => 'collection',
        'name' => 'artworks',
        'moduleName' => 'artworks',
        'label' => 'Artworks',
        'max' => 1
    ])

    @formField('wysiwyg', [
        'name' => 'captionAddendum',
        'label' => 'Caption addendum',
        'note' => 'Appended to generated tombstone',
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

@endcomponent
