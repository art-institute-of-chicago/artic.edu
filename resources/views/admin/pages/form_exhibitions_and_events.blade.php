@section('contentFields')
    @formField('input', [
        'name' => 'exhibition_intro',
        'label' => 'Intro text',
    ])
@stop


@section('fieldsets')

    <a17-fieldset id="current" title="Current exhibitions">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 2,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsExhibitions',
            'label' => 'Featured exhibitions - current'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 12,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsCurrent',
            'label' => 'Secondary features - current'
        ])
    </a17-fieldset>

    <a17-fieldset id="upcoming" title="Upcoming exhibitions">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 2,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsUpcoming',
            'label' => 'Featured exhibitions - upcoming'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 12,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsUpcomingListing',
            'label' => 'Secondary features - upcoming'
        ])
    </a17-fieldset>

@endsection
