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

    <a17-fieldset title="Hours" id="featured_hours">
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="Dining" id="dinning_hours">
        @formField('repeater', ['type' => 'dinning_hours'])
    </a17-fieldset>
@stop
