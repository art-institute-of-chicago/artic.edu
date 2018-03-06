@section('contentFields')
    @formField('medias', [
        'name' => 'visit_hero',
        'label' => 'Hero Image',
    ])

    @formField('medias', [
        'name' => 'visit_mobile',
        'label' => 'Hero Mobile Image',
    ])

    @formField('input', [
        'name' => 'visit_intro',
        'label' => 'Explore all dinning link'
    ])

    @formField('map', [
        'name' => 'location',
        'label' => 'Location',
        'showMap' => true,
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Locations" id="locations">
        @formField('repeater', ['type' => 'locations'])
    </a17-fieldset>

    <a17-fieldset title="Admissions" id="admissions">
        @formField('repeater', ['type' => 'admissions'])
    </a17-fieldset>

    <a17-fieldset title="Featured hours" id="featured_hours">
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="Dinning Hours" id="dinning_hours">
        @formField('repeater', ['type' => 'dinning_hours'])
    </a17-fieldset>
@stop
