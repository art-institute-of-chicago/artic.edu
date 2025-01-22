@section('contentFields')
    <x-twill::input
        name='art_intro'
        label='Intro text'
    />

    <x-twill::browser
        route-prefix='collection'
        :max='25'
        module-name='categoryTerms'
        name='artCategoryTerms'
        'label' => 'Quick filters'
    />

    <x-twill::browser
        name='featured_items'
        label='Featured items'
        route-prefix='collection.articlesPublications'
        module-name='articles'
        :max='5'
        :modules="[
            [
                'label' => 'Article',
                'value' => '/collection/articlesPublications/articles/browser'
            ],
            [
                'label' => 'Interactive feature',
                'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
            ]
        ]"
    />

@stop
