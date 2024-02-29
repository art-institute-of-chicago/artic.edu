@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[4]))->type : null;
    
    switch ($type) {
        case 'RLC':
            $themes = ['rlc'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@formField('select', [
    'name' => 'theme',
    'label' => 'Theme',
    'default' => 'default',
    'options' => collect($themes)->map(function($theme) {
        return [
            'value' => $theme,
            'label' => ucfirst($theme),
        ];
    })->toArray(),
])

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'rlc',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'variation',
        'label' => 'Variation',
        'options' => [
            [
                'value' => 'make-with-us',
                'label' => 'Make with us',
            ],
            [
                'value' => 'experience-with-us',
                'label' => 'Experience with us',
            ],
            [
                'value' => 'learn-with-us',
                'label' => 'Learn with us',
            ],
        ]
    ])

@endcomponent

@twillBlockTitle('Showcase Multiple')
@twillBlockIcon('image')

@formField('input', [
    'name' => 'heading',
    'label' => 'Heading',
    'type' => 'text',
])

@formField('input', [
    'name' => 'intro',
    'label' => 'Intro',
    'type' => 'text',
])

@formField('repeater', ['type' => 'showcase_item'])
