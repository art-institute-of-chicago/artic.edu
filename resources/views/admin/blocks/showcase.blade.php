@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[4]))->type : null;

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
    'fieldValues' => 'rlc',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'variation',
        'label' => 'Variation',
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
        'fieldValues' => 'about-the-rlc',
        'renderForBlocks' => true,
    ])

        @formField('input', [
            'type' => 'text',
            'name' => 'heading',
            'label' => 'Heading',
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

        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'link_label',
                'label' => 'Link Label',
                'type' => 'text',
            ])
        @endslot
        @slot('right')
            @formField('input', [
                'name' => 'link_url',
                'label' => 'Link Url',
                'type' => 'text',
            ])
        @endslot
        @endcomponent

    @endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'default',
        'renderForBlocks' => true,
    ])

        @formField('input', [
            'type' => 'text',
            'name' => 'heading',
            'label' => 'Heading',
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
            'name' => 'date',
            'label' => 'Date',
            'type' => 'text',
        ])

        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'link_label',
                'label' => 'Link Label',
                'type' => 'text',
            ])
        @endslot
        @slot('right')
            @formField('input', [
                'name' => 'link_url',
                'label' => 'Link Url',
                'type' => 'text',
            ])
        @endslot
        @endcomponent

    @endcomponent

@endif

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => ['default', 'home'],
    'renderForBlocks' => true,
    ])

    @formField('input', [
        'type' => 'text',
        'name' => 'heading',
        'label' => 'Heading',
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

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'link_label',
            'label' => 'Link Label',
            'type' => 'text',
        ])
    @endslot
    @slot('right')
        @formField('input', [
            'name' => 'link_url',
            'label' => 'Link Url',
            'type' => 'text',
        ])
    @endslot
    @endcomponent

@endcomponent