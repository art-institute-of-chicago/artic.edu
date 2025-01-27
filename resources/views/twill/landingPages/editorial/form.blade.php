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

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::browser
                name='top_stories'
                label='Top Stories'
                route-prefix='collection.articlesPublications'
                module-name='articles'
                :max='3'
                :modules="[
                    [
                        'label' => 'Article',
                        'name' => 'collection.articlesPublications.articles',
                    ],
                    [
                        'label' => 'Highlight',
                        'name' => 'collection.highlights'
                    ],
                    [
                        'label' => 'Interactive feature',
                        'name' => 'collection.interactiveFeatures.experiences'
                    ],
                    [
                        'label' => 'Video',
                        'name' => 'collection.articlesPublications.videos'
                    ],
                ]"
                :params="[ 'published' => true ]"
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::browser
                name='most_popular_stories'
                label='Most popular stories'
                route-prefix='collection.articlesPublications'
                module-name='articles'
                :max='5'
                :modules="[
                    [
                        'label' => 'Article',
                        'name' => 'collection.articlesPublications.articles'
                    ],
                    [
                        'label' => 'Highlight',
                        'name' => 'collection.highlights'
                    ],
                    [
                        'label' => 'Interactive feature',
                        'name' => 'collection.interactiveFeatures.experiences'
                    ],
                    [
                        'label' => 'Video',
                        'name' => 'collection.articlesPublications.videos'
                    ],
                ]"
            />
        </x-slot:right>
    </x-twill::formColumns>

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
