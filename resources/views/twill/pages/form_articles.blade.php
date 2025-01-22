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
                'value' => '/collection/articlesPublications/articles/browser'
            ],
            [
                'label' => 'Interactive feature',
                'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
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
