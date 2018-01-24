@extends('cms-toolkit::layouts.form')

@section('contentFields')
    {{-- @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ]) --}}

    @formField('select', [
        'name' => 'type',
        'label' => 'Event type',
        'options' => $eventTypesList,
        'default' => '0'
    ])

    @formField('date_picker', [
        'name' => 'start_date',
        'label' => 'Start date',
    ])

    @formField('date_picker', [
        'name' => 'end_date',
        'label' => 'End date'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'hero_caption',
        'label' => 'Hero Image Caption'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'note' => 'Used at the landing page and SEO'
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'type' => 'textarea'
    ])

    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('checkbox', [
        'name' => 'is_private',
        'label' => 'Is Private?',
    ])

    @formField('input', [
        'name' => 'rsvp_link',
        'label' => 'External RSVP Link'
    ])

    {{-- @formField('browser', [
        'routePrefix' => 'whatson',
        'with_multiple' => true,
        'max' => 20,
        'name' => 'events',
        'label' => 'Related events'
    ]) --}}
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'location',
            'label' => 'Location'
        ])

        @formField('checkbox', [
            'name' => 'is_after_hours',
            'label' => 'After Hours?'
        ])

        @formField('checkbox', [
            'name' => 'is_ticketed',
            'label' => 'Ticketed Event?'
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'Free Event?'
        ])
    </a17-fieldset>
@endsection
