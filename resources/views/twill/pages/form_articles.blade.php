@section('contentFields')
    <x-twill::browser
        name='featured_items'
        label='Featured items'
        route-prefix='collection.articlesPublications'
        module-name='articles'
        :max='3'
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

    <x-twill::browser
        name='articlesCategories'
        label='Categories'
        route-prefix='collection.articlesPublications'
        module-name='categories'
        :max='10'
    />
@stop
