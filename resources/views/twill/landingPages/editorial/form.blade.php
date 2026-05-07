@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::input
        name='intro'
        label='Intro Text'
        :maxlength='100'
        :required='true'
    />

    <x-twill::wysiwyg
        name='listing_description'
        label='Listing description'
        note='Max 255 characters'
        :maxlength="255"
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::medias
        name='listing_image'
        label='Listing image'
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
            'tag_banner',
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />

</x-twill::formFieldset>

<x-twill::formFieldset id="metadata" title="Overwrite default metadata (optional)">
    <x-twill::input
        name='meta_title'
        label='Metadata Title'
    />
    <x-twill::input
        name='meta_description'
        label='Metadata Description'
        type='textarea'
    />
    <x-twill::input
        name='search_tags'
        label='Internal Search Tags'
        type='textarea'
    />
    <p>Comma-separated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
</x-twill::formFieldset>

@stop
