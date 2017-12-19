@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('date_picker', [
         'name' => 'start_date',
         'label' => 'Start date',
    ])
    @formField('date_picker', [
         'name' => 'end_date',
         'label' => 'End date',
    ])

    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('checkbox', [
         'name' => 'recurring',
         'label' => 'Recurring event',
    ])

    @formField('input', [
         'name' => 'recurring_start_time',
         'label' => 'Recurring Start time',
    ])
    @formField('input', [
         'name' => 'recurring_end_time',
         'label' => 'Recurring end time',
    ])

    @formField('input', [
        'name' => 'recurring_days',
        'label' => 'Recurring days',
    ])
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID'
    ])
    @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero',
        'with_multiple' => false,
        'no_crop' => false
    ])
    @formField('input', [
        'name' => 'admission',
        'label' => 'Admission',
    ])
    @formField('input', [
        'name' => 'price',
        'label' => 'Price'
    ])
    @formField('input', [
        'name' => 'location',
        'label' => 'Meeting Location'
    ])
    @formField('input', [
        'name' => 'latitude',
        'label' => 'Latitude'
    ])
    @formField('input', [
        'name' => 'longitude',
        'label' => 'Longitude'
    ])
    @formField('input', [
        'name' => 'rsvp_link',
        'label' => 'External RSVP Link'
    ])
    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'events',
        'module_name' => 'events',
        'relationship_name' => 'events',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related events',
        'max' => 20
    ])
@stop
