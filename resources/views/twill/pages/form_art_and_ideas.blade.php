@section('contentFields')
    <x-twill::input
        name='art_intro'
        label='Intro text'
    />

    <x-twill::browser
        name='artCategoryTerms'
        label='Quick filters'
        route-prefix='collection'
        module-name='categoryTerms'
        :max='25'
    />

    <x-twill::browser
        name='featured_items'
        label='Featured items'
        :max='5'
        :modules="[
            [
                'label' => 'Article',
                'name' => 'collection.articlesPublications.articles'
            ],
            [
                'label' => 'Interactive feature',
                'name' => 'collection.interactiveFeatures.experiences'
            ]
        ]"
    />

@stop
