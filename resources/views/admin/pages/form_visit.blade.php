@section('contentFields')
    @formField('medias', [
        'name' => 'visit_hero',
        'label' => 'Hero Image/Video',
    ])

    @formField('medias', [
        'name' => 'visit_mobile',
        'label' => 'Hero Mobile Image',
    ])

    @formField('map', [
        'name' => 'location',
        'label' => 'Museum Location',
        'showMap' => true,
    ])

    @formField('medias', [
        'name' => 'visit_map',
        'label' => 'Museum map',
    ])

    @formField('input', [
        'name' => 'visit_transportation_link',
        'field_name' => 'visit_transportation_link',
        'label' => 'Public Transportation Link',
        'required' => true
    ])

    @formField('input', [
        'name' => 'visit_parking_link',
        'field_name' => 'visit_parking_link',
        'label' => 'Direction & Parking Link',
        'required' => true
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="City Pass" id="citi_pass">
        @formField('medias', [
            'name' => 'visit_city_pass',
            'label' => 'Image',
        ])
        @formField('input', [
            'name' => 'visit_city_pass_title',
            'field_name' => 'visit_city_pass_title',
            'label' => 'Title',
            'required' => true
        ])
        @formField('input', [
            'name' => 'visit_city_pass_text',
            'field_name' => 'visit_city_pass_text',
            'label' => 'Text',
            'rows' => 3,
            'type' => 'textarea'
        ])
        @formField('input', [
            'name' => 'visit_city_pass_button_label',
            'field_name' => 'visit_city_pass_button_label',
            'label' => 'Button Label',
            'required' => true
        ])
        @formField('input', [
            'name' => 'visit_city_pass_link',
            'field_name' => 'visit_city_pass_link',
            'label' => 'Button Link',
            'required' => true
        ])
    </a17-fieldset>

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
        @formField('input', [
            'name' => 'visit_intro',
            'label' => 'Explore all dining link'
        ])

        @formField('repeater', ['type' => 'dining_hours'])
    </a17-fieldset>
@stop
