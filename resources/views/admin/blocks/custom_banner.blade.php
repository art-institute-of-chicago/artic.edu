{{-- @php
    $currentUrl = explode('/', request()->url());
    $type = \App\Models\LandingPage::find(intval($currentUrl[4]))->type;
    
    // Setup code for theming 

    switch ($type) {
        case 'Home':
            $themes = ['default'];
            break;
        case 'Visit':
            $themes = ['default'];
            break;
        case 'RLC':
            $themes = ['default'];
            break;
        default:
            $themes = ['default'];
    }
@endphp --}}

@twillBlockTitle('Custom Banner')
@twillBlockIcon('image')

@formField('radios', [
    'name' => 'background_type',
    'label' => 'Background Type',
    'default' => 'mobile_app',
    'inline' => true,
    'options' => [
        [
            'value' => 'background_image',
            'label' => 'Image'
        ],
        [
            'value' => 'background_color',
            'label' => 'Color'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_image',
    'renderForBlocks' => true
])

    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1,
        'withVideoUrl' => false,
        'required' => true,
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_color',
    'renderForBlocks' => true
])

    @formField('color', [
        'name' => 'bgcolor',
        'label' => 'Background color',
        'default' => '#000000'
    ])

@endcomponent


@formField('input', [
    'name' => 'heading',
    'label' => 'Heading',
    'maxlength' => 100,
    'required' => true,
])

@formField('wysiwyg', [
    'name' => 'body',
    'label' => 'Body',
    'required' => true,
])

@formField('radios', [
    'name' => 'button_type',
    'label' => 'Variation',
    'default' => 'mobile_app',
    'inline' => true,
    'options' => [
        [
            'value' => 'mobile_app',
            'label' => 'Mobile App'
        ],
        [
            'value' => 'custom',
            'label' => 'Custom'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'button_type',
    'fieldValues' => 'custom',
    'renderForBlocks' => true
])

    @formField('input', [
        'name' => 'button_text',
        'label' => 'Button Text',
        'maxlength' => 100,
        'required' => true,
    ])

    @formField('input', [
        'name' => 'button_url',
        'label' => 'Button URL',
        'maxlength' => 100,
        'required' => true,
    ])

@endcomponent
