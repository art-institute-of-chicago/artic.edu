@php
    $currentUrl = explode('/', request()->url());
    $type = \App\Models\LandingPage::find(intval($currentUrl[4]))->type;

    switch ($type) {
        case 'Home':
            $themes = ['default', 'home'];
            break;
        case 'Visit':
            $themes = ['default', 'visit'];
            break;
        case 'RLC':
            $themes = ['default', 'rlc'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Showcase Multiple')
@twillBlockIcon('image')

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
        'default' => 'make-with-us',
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
        ],
    ])
@endcomponent

@formField('input', [
    'name' => 'header',
    'label' => 'Header',
    'type' => 'text',
])

@formField('input', [
    'name' => 'intro',
    'label' => 'Intro',
    'type' => 'textarea',
])

@formField('repeater', ['type' => 'showcase_item'])
