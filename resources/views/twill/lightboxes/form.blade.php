@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'duration', 'label' => 'Duration'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')

    <x-twill::radios
        name='geotarget'
        label='Geotargeting'
        note='"Local" refers to Chicago area'
        default='\App\Models\Lightbox::GEOTARGET_ALL'
        :inline='false'
        :options="[
            [
                'value' => '{{ \App\Models\Lightbox::GEOTARGET_ALL }}',
                'label' => 'All users'
            ],
            [
                'value' => '{{ \App\Models\Lightbox::GEOTARGET_LOCAL }}',
                'label' => 'Local users only'
            ],
            [
                'value' => '{{ \App\Models\Lightbox::GEOTARGET_NOT_LOCAL }}',
                'label' => 'Non-local users only'
            ]
        ]"
    />

    <x-twill::input
        name='header'
        label='Header'
        note='Use "Title Case"'
    />

    <x-twill::wysiwyg
        name='body'
        label='Body'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::input
        name='lightbox_button_text'
        label='Button Text'
        note='Defaults to "Join Now"'
    />

    @php
        $options = [
            [
                'value' => '{{ \App\Models\Lightbox::VARIATION_DEFAULT }}',
                'label' => 'Default (button)'
            ],
            [
                'value' => '{{ \App\Models\Lightbox::VARIATION_NEWSLETTER }}',
                'label' => 'Newsletter (button + email input)'
            ],
            [
                'value' => '{{ \App\Models\Lightbox::VARIATION_EMAIL }}',
                'label' => 'Email capture to landing page(button + email input)'
            ]
        ];

        if (config('aic.show_button_and_date_select_lightbox_variation')) {
            $options[] = [
                'value' => \App\Models\Lightbox::VARIATION_TICKETING,
                'label' => 'Ticketing (button + date select) (WIP)'
            ];
        }
    @endphp
    <x-twill::radios
        name='variation'
        label='Variation'
        default='\App\Models\Lightbox::VARIATION_DEFAULT'
        :inline='false'
        :options="$options"
    />

    <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>
@stop


@section('fieldsets')

    <x-twill::formFieldset id="duration" title="Duration">

        <x-twill::date-picker
            name='lightbox_start_date'
            label='Start Date'
            :withTime='false'
        />

        <x-twill::date-picker
            name='lightbox_end_date'
            label='End Date'
            :withTime='false'
        />

        {{-- Expiry period is in seconds --}}
        <x-twill::radios
            name='expiry_period'
            label='Display Frequency'
            default='86400'
            :inline='true'
            :options="[
                [
                    'value' => 86400,
                    'label' => 'Every 24 hours'
                ],
                [
                    'value' => 0,
                    'label' => 'Always'
                ]
            ]"
        />

    </x-twill::formFieldset>

    <x-twill::formFieldset id="metadata" title="Metadata">

        <p><strong>Note:</strong> Metadata fields are not used for the "Newsletter" variation.</p>

        <hr>

        <x-twill::input
            name='action_url'
            label='Action URL'
            note='e.g. https://join.artic.edu/secure/holiday-annual-fund'
        />

    </x-twill::formFieldset>

@endsection
