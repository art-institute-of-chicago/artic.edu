@section('contentFields')
    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 3,
        'moduleName' => 'homeFeatures',
        'name' => 'mainHomeFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 5,
        'moduleName' => 'homeFeatures',
        'name' => 'secondaryHomeFeatures',
        'label' => 'Secondary features',
        'note' => 'Queue up to 5 home features for the two smaller hero areas',
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 10,
        'moduleName' => 'homeFeatures',
        'name' => 'homeFeatures',
        'label' => 'Home features (DEPRECATED)',
        'note' => 'For reference only! Please use the two fields above instead.',
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 20,
        'moduleName' => 'collectionFeatures',
        'name' => 'collectionFeatures',
        'label' => 'Collection features'
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
        'max' => 10,
        'moduleName' => 'events',
        'name' => 'homeEvents',
        'label' => 'Featured events',
        'note' => 'Select up to 10 events you want to feature on the homepage'
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
