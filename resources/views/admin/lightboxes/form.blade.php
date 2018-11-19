@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'duration', 'label' => 'Duration'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Cover Image',
        'name' => 'cover',
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

    @formField('wysiwyg', [
        'name' => 'terms_text',
        'label' => '"Terms and Conditions" Line',
        'note' => 'e.g "By joining you agree to the Terms and Conditions"',
        'toolbarOptions' => [
            'italic',
            'link',
        ],
    ])

    <p>Please use "/terms" as the "Terms and Conditions" link.</p>

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

    </a17-fieldset>

    <a17-fieldset id="metadata" title="Metadata">

        @formField('input', [
            'name' => 'action_url',
            'label' => 'Action URL',
            'note' => 'e.g. https://join.artic.edu/secure/holiday-annual-fund',
        ])

        @formField('input', [
            'name' => 'form_tlc_source',
            'label' => 'Form TLC Source',
            'note' => 'e.g. AIC17137L01',
        ])

        @formField('input', [
            'name' => 'form_token',
            'label' => 'Form Token',
            'note' => 'e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag',
        ])

        @formField('input', [
            'name' => 'form_id',
            'label' => 'Form ID',
            'note' => 'e.g. webform_client_form_5111',
        ])

    </a17-fieldset>

@endsection
