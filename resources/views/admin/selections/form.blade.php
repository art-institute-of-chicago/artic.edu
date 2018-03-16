@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short intro copy',
        'type' => 'textarea'
    ])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero image'
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'name' => 'artworks',
        'moduleName' => 'artworks',
        'label' => 'Artworks for listing display',
        'max' => 6
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])

    @formField('block_editor', [
        'blocks' => [
            'image', 'video', 'gallery', 'media_embed', 'paragraph', 'artwork', 'artworks'
        ]
    ])
@stop
