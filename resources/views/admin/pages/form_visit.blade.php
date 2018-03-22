@section('contentFields')
    @formField('medias', [
        'name' => 'visit_hero',
        'label' => 'Hero Image/Video',
    ])

    @formField('medias', [
        'name' => 'visit_mobile',
        'label' => 'Hero Mobile Image',
    ])

    @formField('input', [
        'name' => 'visit_intro',
        'label' => 'Explore all dining link'
    ])

    @formField('map', [
        'name' => 'location',
        'label' => 'Museum Location',
        'showMap' => true,
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Museum Address" id="locations">
        @formField('repeater', ['type' => 'locations', 'max' => 2])
    </a17-fieldset>

    <a17-fieldset title="Museum Hours" id="featured_hours">
        @formField('medias', [
            'name' => 'visit_featured_hour',
            'label' => 'Image',
            'max' => '1'
        ])
        @formField('input', [
            'name' => 'visit_hour_header',
            'field_name' => 'visit_hour_header',
            'label' => 'Header',
            'required' => true
        ])
        @formField('input', [
            'type' => 'text',
            'rows' => 3,
            'name' => 'visit_hour_subheader',
            'field_name' => 'visit_hour_subheader',
            'label' => 'Subheader',
            'required' => true
        ])
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="Dining" id="dining_hours">
        @formField('repeater', ['type' => 'dining_hours'])
    </a17-fieldset>
@stop
