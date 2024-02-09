@php
    $currentUrl = explode('/', request()->url());
    $type = \App\Models\LandingPage::find(intval($currentUrl[4]))->type;

    switch ($type) {
        case 'Home':
            $themes = ['default', 'home'];
            $mediaTypes = ['image'];
            break;
        case 'Visit':
            $themes = ['default', 'visit'];
            $mediaTypes = ['image'];
            break;
        case 'RLC':
            $themes = ['default', 'rlc'];
            $mediaTypes = ['image', 'video'];
            break;
        default:
            $themes = ['default'];
            $mediaTypes = ['image', 'video'];
    }
@endphp

@twillBlockTitle('Showcase')
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
    'fieldValues' => 'multiple',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'variation',
        'label' => 'Variation',
        'default' => 'default',
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

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'rlc',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'variation',
        'label' => 'Variation',
        'default' => 'default',
        'options' => [
            [
                'value' => 'default',
                'label' => 'Default',
            ],
            [
                'value' => 'about-the-rlc',
                'label' => 'About the RLC',
            ],
        ]
    ])
@endcomponent

@if (count($mediaTypes) > 1)

    @formField('select', [
        'name' => 'media_type',
        'label' => 'Media Type',
        'required' => true,
        'unpack' => true,
        'options' => collect($mediaTypes)->map(function($media) {
            return [
                'value' => $media,
                'label' => ucfirst($media),
            ];
        })->toArray(),
    ])

    @formConnectedFields([
        'fieldName' => 'media_type',
        'fieldValues' => 'image',
        'renderForBlocks' => true,
    ])
        @formField('medias', [
            'name' => 'image',
            'label' => 'Image',
            'max' => 1,
            'withVideoUrl' => false,
            'required' => true,
        ])
    @endcomponent

    @formConnectedFields([
        'fieldName' => 'media_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true,
    ])
        @formField('files', [
            'name' => 'video',
            'label' => 'Video',
            'max' => 1,
            'required' => true,
        ])
    @endcomponent

@else
    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1,
        'withVideoUrl' => false,
        'required' => true,
    ])
@endif

@if ($type == 'RLC')

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => ['default', 'about-the-rlc'],
        'renderForBlocks' => true,
    ])

        @formField('input', [
            'type' => 'text',
            'name' => 'header',
            'label' => 'Header',
        ])

        @formField('input', [
            'name' => 'tag',
            'label' => 'Tag',
            'type' => 'text',
            'maxlength' => 100,
        ])

        @formField('wysiwyg', [
            'name' => 'title',
            'label' => 'Title',
            'maxlength' => 100,
            'required' => true,
            'toolbarOptions' => [
                    'italic'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'description',
            'label' => 'Description',
            'required' => true,
        ])

        @formField('input', [
            'name' => 'link_label',
            'label' => 'Link Label',
            'type' => 'text',
        ])

        @formField('input', [
            'name' => 'link_url',
            'label' => 'Link Url',
            'type' => 'text',
        ])

    @endcomponent

@endif

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'multiple',
    'renderForBlocks' => true,
    ])

    @formField('input', [
        'name' => 'header',
        'label' => 'Header',
        'type' => 'text',
    ])

    @formField('input', [
        'name' => 'intro',
        'label' => 'Intro',
        'type' => 'text',
    ])

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => ['make-with-us', 'experience-with-us'],
        'renderForBlocks' => true,
    ])
        @formField('repeater', ['type' => 'showcase_item', 'max' => 3])
    @endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'learn-with-us',
        'renderForBlocks' => true,
    ])
        @formField('repeater', ['type' => 'showcase_item', 'max' => 4])
    @endcomponent

@endcomponent
