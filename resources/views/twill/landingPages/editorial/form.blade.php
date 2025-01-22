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

<x-twill::formFieldset title="Top Stories" id="stories_top">

        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::browser
                name='top_stories'
                label='Top Stories'
                route-prefix='collection.articlesPublications'
                module-name='articles'
                :max='3'
                :modules="[
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
                ]"
            />
        @endslot

        @slot('right')
            <x-twill::browser
                name='most_popular_stories'
                label='Most popular stories'
                route-prefix='collection.articlesPublications'
                module-name='articles'
                :max='5'
                :modules="[
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
                ]"
            />
        @endslot
        @endcomponent

</x-twill::formFieldset>

<x-twill::formFieldset title="Custom Content" id="custom_content">

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'feature_block',
            'editorial_block',
            'custom_banner',
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />

</x-twill::formFieldset>

@stop
