@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::input
        name='intro'
        label='Intro Text'
        :maxlength='100'
        :required='true'
    />

@stop

@section('fieldsets')

<a17-fieldset title="Top Stories" id="stories_top">

        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('browser', [
                'routePrefix' => 'collection.articlesPublications',
                'moduleName' => 'articles',
                'name' => 'top_stories',
                'endpoints' => [
                    [
                        'label' => 'Article',
                        'value' => moduleRoute('articles', 'collection.articlesPublications', 'browser', ['published' => true]),
                    ],
                    [
                        'label' => 'Highlight',
                        'value' => moduleRoute('highlights', 'collection', 'browser')
                    ],
                    [
                        'label' => 'Interactive feature',
                        'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
                    ],
                    [
                        'label' => 'Video',
                        'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser'),
                    ],
                ],
                'max' => 3,
                'label' => 'Top Stories',
            ])
        @endslot

        @slot('right')
            @formField('browser', [
                'routePrefix' => 'collection.articlesPublications',
                'moduleName' => 'articles',
                'name' => 'most_popular_stories',
                'endpoints' => [
                    [
                        'label' => 'Article',
                        'value' => '/collection/articlesPublications/articles/browser'
                    ],
                    [
                        'label' => 'Highlight',
                        'value' => moduleRoute('highlights', 'collection', 'browser')
                    ],
                    [
                        'label' => 'Interactive feature',
                        'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
                    ],
                    [
                        'label' => 'Video',
                        'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser'),
                    ],
                ],
                'max' => 5,
                'label' => 'Most popular stories',
            ])
        @endslot
        @endcomponent

</a17-fieldset>

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'feature_block',
            'editorial_block',
            'custom_banner',
        ])
    ])

</a17-fieldset>

@stop
