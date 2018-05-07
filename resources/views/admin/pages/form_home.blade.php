@section('contentFields')
    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('browser', [
    'routePrefix' => 'homepage',
        'max' => 10,
        'moduleName' => 'homeFeatures',
        'name' => 'homeFeatures',
        'label' => 'Home features'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 2,
        'moduleName' => 'exhibitions',
        'name' => 'homeExhibitions',
        'label' => 'Featured exhibitions'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 4,
        'moduleName' => 'events',
        'name' => 'homeEvents',
        'label' => 'Featured events',
        'note' => 'Select up to 4 events you want to feature on the homepage'
    ])

    @formField('browser', [
    'routePrefix' => 'homepage',
        'max' => 10,
        'moduleName' => 'collectionFeatures',
        'name' => 'collectionFeatures',
        'label' => 'Collection features'
    ])

    @formField('browser', [
        'routePrefix' => 'general',
        'max' => 5,
        'moduleName' => 'shopItems',
        'name' => 'homeShopItems',
        'label' => 'Featured shop items',
        'note' => 'Select up to 5 shop items you want to feature on the homepage'
    ])

@stop

@section('fieldsets')
    <a17-fieldset title="Membership Module" id="membership">

        @formField('medias', [
            'label' => 'Image',
            'name' => 'home_membership_module_image'
        ])

        @formField('input', [
            'name' => 'home_membership_module_headline',
            'label' => 'Headline',
        ])

        @formField('input', [
            'name' => 'home_membership_module_short_copy',
            'label' => 'Short copy',
        ])

        @formField('input', [
            'name' => 'home_membership_module_button_text',
            'label' => 'Button text',
        ])

        @formField('input', [
            'name' => 'home_membership_module_url',
            'label' => 'URL',
        ])

    </a17-fieldset>
@stop
