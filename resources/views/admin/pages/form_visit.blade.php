@push('extra_js')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API_KEY') !!}&maptype=roadmap"></script>
    <script src="{{ mix('/assets/admin/behaviors/google_maps.js') }}"></script>
@endpush

@formField('medias', [
    'name' => 'visit_hero',
    'label' => 'Hero Image',
    'with_multiple' => false,
    'no_crop' => false
])

@formField('repeater', [
    'type' => 'locations',
    'title' => 'Locations',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Locations'
])


@formField('repeater', [
    'type' => 'admissions',
    'title' => 'Free Admissions',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Free Admission'
])

@formField('repeater', [
    'type' => 'featured_hours',
    'title' => 'Hours',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Hour'
])

@formField('repeater', [
    'type' => 'dinning_hours',
    'title' => 'Dinning Hours',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Dinning Hour'
])

@formField('map', [
    'name' => 'location',
    'label' => 'Location',
    'showMap' => true,
])
