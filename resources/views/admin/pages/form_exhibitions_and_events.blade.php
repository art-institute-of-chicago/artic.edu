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
            'max' => 24,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsCurrent',
            'label' => 'Current exhibitions',
            'note' => 'Top 2 exhibitions will be featured'
        ])
    </a17-fieldset>

    <a17-fieldset id="upcoming" title="Upcoming exhibitions">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 8,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsUpcoming',
            'label' => 'Featured exhibitions - upcoming'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 18,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitionsUpcomingListing',
            'label' => 'Secondary features - upcoming'
        ])
    </a17-fieldset>

@endsection
