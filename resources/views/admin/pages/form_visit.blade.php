@push('extra_js')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API_KEY') !!}&maptype=roadmap"></script>
    <script src="{{ mix('/assets/admin/behaviors/google_maps.js') }}"></script>
@endpush

@formField('input', [
    'label' => 'Intro text',
    'name' => 'visit_intro',
    'field_name' => 'Intro text',
])

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

<section class="box" data-behavior="google_maps" data-zoom="15" data-latlng-center="41.8794774,-87.6222743" data-latlng="41.877486,-87.623285|41.881674,-87.621061">
    <header class="header_small">
        <h3><b>Map that will be shown at the FE</b></h3>
    </header>

    <div class="map-canvas"></div>
</section>
