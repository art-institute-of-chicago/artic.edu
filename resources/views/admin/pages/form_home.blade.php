@section('contentFields')
    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 4,
        'moduleName' => 'exhibitions',
        'name' => 'homeExhibitions',
        'label' => 'Related Exhibitions'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 4,
        'moduleName' => 'events',
        'name' => 'homeEvents',
        'label' => 'Related Events',
        'note' => 'Select up to 3 events you want to feature on the homepage'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 5,
        'moduleName' => 'shopItems',
        'name' => 'homeShopItems',
        'label' => 'Related Shop items',
        'note' => 'Select up to 3 shop items you want to feature on the homepage'
    ])
@stop
