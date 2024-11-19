@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'duration', 'label' => 'Duration'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')

    @formField('radios', [
        'name' => 'geotarget',
        'label' => 'Geotargeting',
        'note' => '"Local" refers to Chicago area',
        'default' => \App\Models\Lightbox::GEOTARGET_ALL,
        'inline' => false,
        'options' => [
            [
                'value' => \App\Models\Lightbox::GEOTARGET_ALL,
                'label' => 'All users'
            ],
            [
                'value' => \App\Models\Lightbox::GEOTARGET_LOCAL,
                'label' => 'Local users only'
            ],
            [
                'value' => \App\Models\Lightbox::GEOTARGET_NOT_LOCAL,
                'label' => 'Non-local users only'
            ]
        ],
    ])

    @formField('input', [
        'name' => 'header',
        'label' => 'Header',
        'note' => 'Use "Title Case"',
    ])

    @formField('wysiwyg', [
        'name' => 'body',
        'label' => 'Body',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('input', [
        'name' => 'lightbox_button_text',
        'label' => 'Button Text',
        'note' => 'Defaults to "Join Now"',
    ])

    @formField('radios', [
        'name' => 'variation',
        'label' => 'Variation',
        'default' => \App\Models\Lightbox::VARIATION_DEFAULT,
        'inline' => false,
        'options' => array_merge([
            [
                'value' => \App\Models\Lightbox::VARIATION_DEFAULT,
                'label' => 'Default (button)'
            ],
            [
                'value' => \App\Models\Lightbox::VARIATION_NEWSLETTER,
                'label' => 'Newsletter (button + email input)'
            ],
            [
                'value' => \App\Models\Lightbox::VARIATION_EMAIL,
                'label' => 'Email capture to landing page(button + email input)'
            ],
        ], !config('aic.show_button_and_date_select_lightbox_variation') ? [] : [
            [
               'value' => \App\Models\Lightbox::VARIATION_TICKETING,
               'label' => 'Ticketing (button + date select) (WIP)'
            ],
        ]),
    ])

    <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>
@stop


@section('fieldsets')

    <a17-fieldset id="duration" title="Duration">

        @formField('date_picker', [
            'name' => 'lightbox_start_date',
            'label' => 'Start Date',
            'withTime' => false
        ])

        @formField('date_picker', [
            'name' => 'lightbox_end_date',
            'label' => 'End Date',
            'withTime' => false
        ])

        {{-- Expiry period is in seconds --}}
        @formField('radios', [
            'name' => 'expiry_period',
            'label' => 'Display Frequency',
            'default' => 86400,
            'inline' => true,
            'options' => [
                [
                    'value' => 86400,
                    'label' => 'Every 24 hours'
                ],
                [
                    'value' => 0,
                    'label' => 'Always'
                ],
            ]
        ])

    </a17-fieldset>

    <a17-fieldset id="metadata" title="Metadata">

        <p><strong>Note:</strong> Metadata fields are not used for the "Newsletter" variation.</p>

        <hr>

        @formField('input', [
            'name' => 'action_url',
            'label' => 'Action URL',
            'note' => 'e.g. https://join.artic.edu/secure/holiday-annual-fund',
        ])

    </a17-fieldset>

@endsection
