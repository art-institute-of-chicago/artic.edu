@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])

    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'

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
        'with_multiple' => true,
        'max' => 20,
        'name' => 'events',
        'label' => 'Related events'
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="API Fields">
        @foreach($item->getApiFields() as $field => $value)
            @formField('input', [
                'name' => $field,
                'label' => $field,
                'disabled' => true
            ])
        @endforeach
    </a17-fieldset>
@endsection
